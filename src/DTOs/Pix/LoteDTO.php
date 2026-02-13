<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class LoteDTO implements DTOInterface
{
    public ?string $descricao;

    /** @var CobvDTO[] */
    public array $cobsv;

    public ?int $id;
    public ?string $criacao;

    /**
     * @param CobvDTO[] $cobsv
     */
    public function __construct(
        array $cobsv,
        ?string $descricao = null,
        ?int $id = null,
        ?string $criacao = null
    ) {
        $this->cobsv = $cobsv;
        $this->descricao = $descricao;
        $this->id = $id;
        $this->criacao = $criacao;
    }

    public function toArray(): array
    {
        return array_filter([
            'descricao' => $this->descricao,
            'cobsv' => array_map(fn ($cob) => $cob->toArray(), $this->cobsv),
            'id' => $this->id,
            'criacao' => $this->criacao,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        $cobsv = [];
        if (isset($data['cobsv']) && is_array($data['cobsv'])) {
            $cobsv = array_map(fn ($item) => CobvDTO::fromArray($item), $data['cobsv']);
        }

        return new self(
            $cobsv,
            $data['descricao'] ?? null,
            $data['id'] ?? null,
            $data['criacao'] ?? null
        );
    }
}
