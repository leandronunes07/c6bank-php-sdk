<?php

namespace LeandroNunes\C6Bank\DTOs\C6Pay;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class C6PayItemDTO implements DTOInterface
{
    public ?string $paymentId;
    public ?float $amount;
    public ?float $netAmount; // Valor líquido
    public ?string $status;
    public ?string $date;
    public ?string $brand; // Visa/Master
    public ?string $paymentType; // Debit/Credit

    public function __construct(
        ?string $paymentId = null,
        ?float $amount = null,
        ?float $netAmount = null,
        ?string $status = null,
        ?string $date = null,
        ?string $brand = null,
        ?string $paymentType = null
    ) {
        $this->paymentId = $paymentId;
        $this->amount = $amount;
        $this->netAmount = $netAmount;
        $this->status = $status;
        $this->date = $date;
        $this->brand = $brand;
        $this->paymentType = $paymentType;
    }

    public function toArray(): array
    {
        return array_filter([
            'paymentId' => $this->paymentId,
            'amount' => $this->amount,
            'netAmount' => $this->netAmount,
            'status' => $this->status,
            'date' => $this->date,
            'brand' => $this->brand,
            'paymentType' => $this->paymentType,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['paymentId'] ?? null,
            (float) ($data['amount'] ?? 0.0),
            (float) ($data['netAmount'] ?? 0.0),
            $data['status'] ?? null,
            $data['date'] ?? null,
            $data['brand'] ?? null,
            $data['paymentType'] ?? null
        );
    }
}
