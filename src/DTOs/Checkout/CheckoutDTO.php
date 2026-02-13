<?php

namespace LeandroNunes\C6Bank\DTOs\Checkout;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class CheckoutDTO implements DTOInterface
{
    public ?string $id;
    public float $amount;
    public string $description;
    public string $externalReferenceId;
    public PayerDTO $payer;
    public PaymentSettingsDTO $payment;
    public ?string $redirectUrl;
    public ?string $status;
    public ?string $paymentUrl; // URL for redirection

    public function __construct(
        float $amount,
        string $description,
        string $externalReferenceId,
        PayerDTO $payer,
        PaymentSettingsDTO $payment,
        ?string $redirectUrl = null,
        ?string $id = null,
        ?string $status = null,
        ?string $paymentUrl = null
    ) {
        $this->amount = $amount;
        $this->description = $description;
        $this->externalReferenceId = $externalReferenceId;
        $this->payer = $payer;
        $this->payment = $payment;
        $this->redirectUrl = $redirectUrl;
        $this->id = $id;
        $this->status = $status;
        $this->paymentUrl = $paymentUrl;
    }

    public function toArray(): array
    {
        return array_filter([
            'amount' => $this->amount,
            'description' => $this->description,
            'external_reference_id' => $this->externalReferenceId,
            'payer' => $this->payer->toArray(),
            'payment' => $this->payment->toArray(),
            'redirect_url' => $this->redirectUrl,
            'id' => $this->id,
            'status' => $this->status,
            'payment_url' => $this->paymentUrl,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (float) ($data['amount'] ?? 0.0),
            $data['description'] ?? '',
            $data['external_reference_id'] ?? '',
            PayerDTO::fromArray($data['payer'] ?? []),
            PaymentSettingsDTO::fromArray($data['payment'] ?? []),
            $data['redirect_url'] ?? null,
            $data['id'] ?? null,
            $data['status'] ?? null,
            $data['payment_url'] ?? null
        );
    }
}
