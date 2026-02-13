<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class LocationDTO implements DTOInterface
{
    public ?int $id;
    public ?string $location;
    public ?string $tipoCob;
    public ?string $criacao;
    public ?string $txid;

    public function __construct(
        ?int $id = null,
        ?string $location = null,
        ?string $tipoCob = null,
        ?string $criacao = null,
        ?string $txid = null
    ) {
        $this->id = $id;
        $this->location = $location;
        $this->tipoCob = $tipoCob;
        $this->criacao = $criacao;
        $this->txid = $txid;
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'location' => $this->location,
            'tipoCob' => $this->tipoCob,
            'criacao' => $this->criacao,
            'txid' => $this->txid,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['location'] ?? null,
            $data['tipoCob'] ?? null,
            $data['criacao'] ?? null,
            $data['txid'] ?? null
        );
    }
}
