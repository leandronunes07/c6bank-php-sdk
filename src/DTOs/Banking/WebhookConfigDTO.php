<?php

namespace LeandroNunes\C6Bank\DTOs\Banking;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class WebhookConfigDTO implements DTOInterface
{
    public string $url;
    public string $service;
    public ?string $eventType;

    public function __construct(string $url, string $service, ?string $eventType = null)
    {
        $this->url = $url;
        $this->service = $service;
        $this->eventType = $eventType;
    }

    public function toArray(): array
    {
        return array_filter([
            'url' => $this->url,
            'service' => $this->service,
            'eventType' => $this->eventType,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['url'] ?? '',
            $data['service'] ?? '',
            $data['eventType'] ?? null
        );
    }
}
