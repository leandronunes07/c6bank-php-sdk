<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class InfoAdicionalDTO implements DTOInterface
{
    public string $nome;
    public string $valor;

    public function __construct(string $nome, string $valor)
    {
        $this->name = $nome;
        $this->value = $valor;
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'valor' => $this->valor,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nome'] ?? '',
            $data['valor'] ?? ''
        );
    }
}
