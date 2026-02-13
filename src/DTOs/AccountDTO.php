<?php

namespace LeandroNunes\C6Bank\DTOs;

class AccountDTO implements DTOInterface
{
    public string $id;
    public string $name;
    public float $balance;
    public string $currency;

    public function __construct(string $id, string $name, float $balance, string $currency = 'BRL')
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
        $this->currency = $currency;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->balance,
            'currency' => $this->currency,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            $data['name'] ?? '',
            (float) ($data['balance'] ?? 0.0),
            $data['currency'] ?? 'BRL'
        );
    }
}
