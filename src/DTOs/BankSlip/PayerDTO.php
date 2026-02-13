<?php

namespace LeandroNunes\C6Bank\DTOs\BankSlip;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class PayerDTO implements DTOInterface
{
    public string $name;
    public string $document; // CPF or CNPJ
    public string $documentType; // CPF or CNPJ
    public AddressDTO $address;

    public function __construct(
        string $name,
        string $document,
        AddressDTO $address
    ) {
        $this->name = $name;
        $this->document = preg_replace('/\D/', '', $document);
        $this->documentType = strlen($this->document) > 11 ? 'CNPJ' : 'CPF';
        $this->address = $address;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'document' => $this->document,
            'documentType' => $this->documentType,
            'address' => $this->address->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['document'] ?? '',
            AddressDTO::fromArray($data['address'] ?? [])
        );
    }
}
