<?php

namespace LeandroNunes\C6Bank\DTOs\Statement;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class StatementItemDTO implements DTOInterface
{
    public ?string $id;
    public ?string $description;
    public ?float $amount;
    public ?string $date;
    public ?string $type; // DEBIT / CREDIT

    public function __construct(
        ?string $id = null,
        ?string $description = null,
        ?float $amount = null,
        ?string $date = null,
        ?string $type = null
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->date = $date;
        $this->type = $type;
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $this->date,
            'type' => $this->type,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['description'] ?? null,
            (float) ($data['amount'] ?? 0.0),
            $data['date'] ?? null,
            $data['type'] ?? null
        );
    }
}
