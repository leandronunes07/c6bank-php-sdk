<?php

namespace LeandroNunes\C6Bank\DTOs\BankSlip;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class BankSlipDTO implements DTOInterface
{
    public ?string $id;
    public float $amount; // Valor do boleto
    public string $dueDate; // YYYY-MM-DD
    public ?string $yourNumber; // Seu número (identificador do cliente)
    public PayerDTO $payer;
    public ?string $pdfUrl; // URL para download (se disponível)
    public ?string $barCode; // Código de barras
    public ?string $digitableLine; // Linha digitável
    public ?string $status;

    public function __construct(
        float $amount,
        string $dueDate,
        PayerDTO $payer,
        ?string $yourNumber = null,
        ?string $id = null,
        ?string $pdfUrl = null,
        ?string $barCode = null,
        ?string $digitableLine = null,
        ?string $status = null
    ) {
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        $this->payer = $payer;
        $this->yourNumber = $yourNumber;
        $this->id = $id;
        $this->pdfUrl = $pdfUrl;
        $this->barCode = $barCode;
        $this->digitableLine = $digitableLine;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'amount' => $this->amount,
            'dueDate' => $this->dueDate,
            'yourNumber' => $this->yourNumber,
            'payer' => $this->payer->toArray(),
            'pdfUrl' => $this->pdfUrl,
            'barCode' => $this->barCode,
            'digitableLine' => $this->digitableLine,
            'status' => $this->status,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (float) ($data['amount'] ?? 0.0),
            $data['dueDate'] ?? '',
            PayerDTO::fromArray($data['payer'] ?? []),
            $data['yourNumber'] ?? null,
            $data['id'] ?? null,
            $data['pdfUrl'] ?? null,
            $data['barCode'] ?? null,
            $data['digitableLine'] ?? null,
            $data['status'] ?? null
        );
    }
}
