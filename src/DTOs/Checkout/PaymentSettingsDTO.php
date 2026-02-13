<?php

namespace LeandroNunes\C6Bank\DTOs\Checkout;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class PaymentSettingsDTO implements DTOInterface
{
    public ?array $card;
    public ?array $pix;

    public function __construct(?array $card = null, ?array $pix = null)
    {
        $this->card = $card;
        $this->pix = $pix;
    }

    public function toArray(): array
    {
        return array_filter([
            'card' => $this->card,
            'pix' => $this->pix,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['card'] ?? null,
            $data['pix'] ?? null
        );
    }
}
