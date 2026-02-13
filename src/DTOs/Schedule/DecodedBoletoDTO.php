<?php

namespace LeandroNunes\C6Bank\DTOs\Schedule;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class DecodedBoletoDTO implements DTOInterface
{
    public ?float $amount;
    public ?string $bankCode;
    public ?string $bankName;
    public ?string $beneficiaryName;
    public ?string $payerName;
    public ?string $dueDate; // transaction_date in JSON example seems empty usually in decode response for some fields?
    public ?string $description;

    public function __construct(
        ?float $amount = null,
        ?string $bankCode = null,
        ?string $bankName = null,
        ?string $beneficiaryName = null,
        ?string $payerName = null,
        ?string $dueDate = null,
        ?string $description = null
    ) {
        $this->amount = $amount;
        $this->bankCode = $bankCode;
        $this->bankName = $bankName;
        $this->beneficiaryName = $beneficiaryName;
        $this->payerName = $payerName;
        $this->dueDate = $dueDate;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return array_filter([
            'amount' => $this->amount,
            'bank_code' => $this->bankCode,
            'bank_name' => $this->bankName,
            'beneficiary_name' => $this->beneficiaryName,
            'payer_name' => $this->payerName,
            'transaction_date' => $this->dueDate,
            'description' => $this->description,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (float) ($data['amount'] ?? 0.0),
            $data['bank_code'] ?? null,
            $data['bank_name'] ?? null,
            $data['beneficiary_name'] ?? null,
            $data['payer_name'] ?? null,
            $data['transaction_date'] ?? null,
            $data['description'] ?? null
        );
    }
}
