<?php

namespace LeandroNunes\C6Bank\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use LeandroNunes\C6Bank\Auth\Authenticator;
use LeandroNunes\C6Bank\Exceptions\C6BankException;
use Psr\Log\LoggerInterface;

class Client
{
    private Authenticator $authenticator;
    private GuzzleClient $httpClient;
    private string $baseUrl;
    private ?LoggerInterface $logger;

    public function __construct(
        Authenticator $authenticator,
        string $baseUrl,
        array $guzzleOptions = [],
        ?LoggerInterface $logger = null
    ) {
        $this->authenticator = $authenticator;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->logger = $logger;

        $defaultOptions = [
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];

        $this->httpClient = new GuzzleClient(array_merge_recursive($defaultOptions, $guzzleOptions));
    }

    public function get(string $uri, array $query = []): array
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    public function post(string $uri, array $data = []): array
    {
        return $this->request('POST', $uri, ['json' => $data]);
    }

    public function put(string $uri, array $data = []): array
    {
        return $this->request('PUT', $uri, ['json' => $data]);
    }

    public function patch(string $uri, array $data = []): array
    {
        return $this->request('PATCH', $uri, ['json' => $data]);
    }

    public function delete(string $uri, array $data = []): array
    {
        return $this->request('DELETE', $uri, ['json' => $data]);
    }

    private function request(string $method, string $uri, array $options = []): array
    {
        try {
            $token = $this->authenticator->getAccessToken();
            $options['headers']['Authorization'] = 'Bearer ' . $token;

            if ($this->logger) {
                $this->logger->info("C6Bank API Request: {$method} {$uri}", [
                    // Redact sensitive data if needed, e.g. authorization
                    'headers' => array_merge($options['headers'], ['Authorization' => 'Bearer ***']),
                    'body' => $options['json'] ?? $options['query'] ?? [],
                ]);
            }

            $response = $this->httpClient->request($method, $uri, $options);
            $contents = $response->getBody()->getContents();

            if ($this->logger) {
                $this->logger->info("C6Bank API Response: {$response->getStatusCode()}", [
                    'body' => substr($contents, 0, 1000), // Truncate logs if too big
                ]);
            }

            return json_decode($contents, true) ?: [];
        } catch (GuzzleException $e) {
            if ($this->logger) {
                $this->logger->error("C6Bank API Error: " . $e->getMessage(), [
                    'exception' => $e,
                ]);
            }

            throw new C6BankException('API Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
