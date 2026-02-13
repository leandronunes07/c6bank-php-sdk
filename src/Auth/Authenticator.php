<?php

namespace LeandroNunes\C6Bank\Auth;

use GuzzleHttp\Client as GuzzleClient;
use LeandroNunes\C6Bank\Exceptions\C6BankException;
use Psr\SimpleCache\CacheInterface;

class Authenticator
{
    private string $clientId;
    private string $clientSecret;
    private string $tokenUrl;
    private ?string $accessToken = null;
    private ?int $expiresAt = null;
    private GuzzleClient $httpClient;
    private ?CacheInterface $cache;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $tokenUrl = 'https://auth.c6bank.com.br/auth/realms/c6bank/protocol/openid-connect/token',
        ?CacheInterface $cache = null
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->tokenUrl = $tokenUrl;
        $this->httpClient = new GuzzleClient();
        $this->cache = $cache;
    }

    public function getAccessToken(): string
    {
        // 1. Check Memory
        if ($this->accessToken && $this->expiresAt && time() < $this->expiresAt) {
            return $this->accessToken;
        }

        // 2. Check Cache
        if ($this->cache) {
            $cacheKey = 'c6bank_token_' . md5($this->clientId);
            $cachedToken = $this->cache->get($cacheKey);
            if ($cachedToken) {
                $this->accessToken = $cachedToken;

                return $this->accessToken;
            }
        }

        return $this->requestNewToken();
    }

    private function requestNewToken(): string
    {
        try {
            $response = $this->httpClient->post($this->tokenUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['access_token'])) {
                throw new C6BankException('Failed to retrieve access token: ' . json_encode($data));
            }

            $this->accessToken = $data['access_token'];
            $expiresIn = $data['expires_in'] ?? 3600;
            $this->expiresAt = time() + $expiresIn - 60; // buffer of 60s

            // 3. Save to Cache
            if ($this->cache) {
                $cacheKey = 'c6bank_token_' . md5($this->clientId);
                $this->cache->set($cacheKey, $this->accessToken, $expiresIn - 60);
            }

            return $this->accessToken;
        } catch (\Throwable $e) {
            throw new C6BankException('Authentication failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
