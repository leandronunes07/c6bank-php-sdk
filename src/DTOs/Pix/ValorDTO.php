<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class ValorDTO implements DTOInterface
{
    public string $original;
    public ?int $modalidadeAlteracao; // 0 (não permite) ou 1 (permite) - Cob

    // CobV specifics
    public ?array $multa;
    public ?array $juros;
    public ?array $abatimento;
    public ?array $desconto;

    public function __construct(
        string $original,
        ?int $modalidadeAlteracao = null,
        ?array $multa = null,
        ?array $juros = null,
        ?array $abatimento = null,
        ?array $desconto = null
    ) {
        $this->original = number_format((float) $original, 2, '.', '');
        $this->modalidadeAlteracao = $modalidadeAlteracao;
        $this->multa = $multa;
        $this->juros = $juros;
        $this->abatimento = $abatimento;
        $this->desconto = $desconto;
    }

    public function toArray(): array
    {
        return array_filter([
            'original' => $this->original,
            'modalidadeAlteracao' => $this->modalidadeAlteracao,
            'multa' => $this->multa,
            'juros' => $this->juros,
            'abatimento' => $this->abatimento,
            'desconto' => $this->desconto,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['original'] ?? '0.00',
            $data['modalidadeAlteracao'] ?? null,
            $data['multa'] ?? null,
            $data['juros'] ?? null,
            $data['abatimento'] ?? null,
            $data['desconto'] ?? null
        );
    }
}
