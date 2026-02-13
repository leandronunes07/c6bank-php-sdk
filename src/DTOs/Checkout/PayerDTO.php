<?php

namespace LeandroNunes\C6Bank\DTOs\Checkout;

use LeandroNunes\C6Bank\DTOs\DTOInterface;
use LeandroNunes\C6Bank\Helpers\Validator;

class PayerDTO implements DTOInterface
{
    public string $name;
    public string $taxId; // CPF/CNPJ
    public string $email;
    public ?string $phoneNumber;
    public ?array $address; // Can be improved to AddressDTO later if needed

    public function __construct(
        string $name,
        string $taxId,
        string $email,
        ?string $phoneNumber = null,
        ?array $address = null
    ) {
        $this->name = $name;
        $this->taxId = preg_replace('/\D/', '', $taxId);

        if (strlen($this->taxId) === 11) {
            Validator::validateCpf($this->taxId);
        } elseif (strlen($this->taxId) === 14) {
            Validator::validateCnpj($this->taxId);
        } else {
            throw new \InvalidArgumentException("Invalid Tax ID length (must be 11 for CPF or 14 for CNPJ): " . $this->taxId);
        }

        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'tax_id' => $this->taxId,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'address' => $this->address,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['tax_id'] ?? '',
            $data['email'] ?? '',
            $data['phone_number'] ?? null,
            $data['address'] ?? null
        );
    }
}
