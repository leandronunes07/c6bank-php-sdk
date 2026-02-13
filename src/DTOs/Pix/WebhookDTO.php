<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class WebhookDTO implements DTOInterface
{
    public string $webhookUrl;
    public ?string $chave;
    public ?string $criacao;

    public function __construct(string $webhookUrl, ?string $chave = null, ?string $criacao = null)
    {
        $this->webhookUrl = $webhookUrl;
        $this->chave = $chave;
        $this->criacao = $criacao;
    }

    public function toArray(): array
    {
        return array_filter([
            'webhookUrl' => $this->webhookUrl,
            'chave' => $this->chave,
            'criacao' => $this->criacao,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['webhookUrl'] ?? '',
            $data['chave'] ?? null,
            $data['criacao'] ?? null
        );
    }
}
