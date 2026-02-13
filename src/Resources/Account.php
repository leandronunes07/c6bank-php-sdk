<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\AccountDTO;

class Account extends Resource
{
    public function getAccount(string $accountId): AccountDTO
    {
        $response = $this->client->get("/accounts/{$accountId}");

        return AccountDTO::fromArray($response);
    }

    // Example method to list accounts
    public function listAccounts(): array
    {
        $response = $this->client->get('/accounts');

        // Assuming response is an array of accounts
        return array_map(fn ($item) => AccountDTO::fromArray($item), $response['data'] ?? []);
    }
}
