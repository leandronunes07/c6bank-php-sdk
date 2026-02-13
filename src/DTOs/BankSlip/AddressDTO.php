<?php

namespace LeandroNunes\C6Bank\DTOs\BankSlip;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class AddressDTO implements DTOInterface
{
    public string $street;
    public string $number;
    public ?string $complement;
    public string $neighborhood;
    public string $city;
    public string $state; // UF (e.g., SP, RJ)
    public string $zipCode; // CEP (only numbers)

    public function __construct(
        string $street,
        string $number,
        string $neighborhood,
        string $city,
        string $state,
        string $zipCode,
        ?string $complement = null
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = preg_replace('/\D/', '', $zipCode); // Ensure only numbers
        $this->complement = $complement;
    }

    public function toArray(): array
    {
        return array_filter([
            'street' => $this->street,
            'number' => (int) $this->number,
            'complement' => $this->complement,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zipCode,
        ], fn($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['street'] ?? '',
            $data['number'] ?? '',
            $data['neighborhood'] ?? '',
            $data['city'] ?? '',
            $data['state'] ?? '',
            $data['zip_code'] ?? $data['zipCode'] ?? '', // Support both
            $data['complement'] ?? null
        );
    }
}
