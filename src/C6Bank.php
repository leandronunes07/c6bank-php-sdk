<?php

namespace LeandroNunes\C6Bank;

use LeandroNunes\C6Bank\Auth\Authenticator;
use LeandroNunes\C6Bank\Http\Client;

class C6Bank
{
    private Client $client;

    public const SANDBOX_URL = 'https://sandbox-api.c6bank.com.br'; // Example URL
    public const PRODUCTION_URL = 'https://api.c6bank.com.br'; // Example URL

    public function __construct(array $config)
    {
        $clientId = $config['client_id'] ?? throw new \InvalidArgumentException('client_id is required');
        $clientSecret = $config['client_secret'] ?? throw new \InvalidArgumentException('client_secret is required');
        $sandbox = $config['sandbox'] ?? false;
        $baseUrl = $sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;

        // Optional: Custom Guzzle options for certificates
        $guzzleOptions = [];
        if (isset($config['certificate'])) {
            $guzzleOptions['cert'] = $config['certificate'];
        }
        if (isset($config['private_key'])) {
            $guzzleOptions['ssl_key'] = $config['private_key'];
        }

        $cache = $config['cache'] ?? null;
        $logger = $config['logger'] ?? null;

        $authenticator = new Authenticator($clientId, $clientSecret, 'https://auth.c6bank.com.br/auth/realms/c6bank/protocol/openid-connect/token', $cache);
        $this->client = new Client($authenticator, $baseUrl, $guzzleOptions, $logger);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function accounts(): Resources\Account
    {
        return new Resources\Account($this->client);
    }

    public function bankSlips(): Resources\BankSlip
    {
        return new Resources\BankSlip($this->client);
    }

    public function pix(): Resources\Pix
    {
        return new Resources\Pix($this->client);
    }

    public function bankingWebhook(): Resources\BankingWebhook
    {
        return new Resources\BankingWebhook($this->client);
    }

    public function checkout(): Resources\Checkout
    {
        return new Resources\Checkout($this->client);
    }

    public function schedule(): Resources\Schedule
    {
        return new Resources\Schedule($this->client);
    }

    public function statement(): Resources\Statement
    {
        return new Resources\Statement($this->client);
    }

    public function c6pay(): Resources\C6Pay
    {
        return new Resources\C6Pay($this->client);
    }
}
