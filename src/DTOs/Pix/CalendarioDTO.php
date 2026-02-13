<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class CalendarioDTO implements DTOInterface
{
    public ?int $expiracao; // Segundos (Cob)
    public ?string $dataDeVencimento; // YYYY-MM-DD (CobV)
    public ?int $validadeAposVencimento; // Dias (CobV)
    public ?string $criacao; // Read-only

    public function __construct(
        ?int $expiracao = null,
        ?string $dataDeVencimento = null,
        ?int $validadeAposVencimento = null,
        ?string $criacao = null
    ) {
        $this->expiracao = $expiracao;
        $this->dataDeVencimento = $dataDeVencimento;
        $this->validadeAposVencimento = $validadeAposVencimento;
        $this->criacao = $criacao;
    }

    public function toArray(): array
    {
        return array_filter([
            'expiracao' => $this->expiracao,
            'dataDeVencimento' => $this->dataDeVencimento,
            'validadeAposVencimento' => $this->validadeAposVencimento,
            'criacao' => $this->criacao, // Usually read-only, but good for DTO completeness
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['expiracao'] ?? null,
            $data['dataDeVencimento'] ?? null,
            $data['validadeAposVencimento'] ?? null,
            $data['criacao'] ?? null
        );
    }
}
