<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class DevedorDTO implements DTOInterface
{
    use LeandroNunes\C6Bank\Helpers\Validator;
    public ?string $nome;
    public ?string $cpf;
    public ?string $cnpj;
    public ?string $email;
    public ?string $logradouro;
    public ?string $cidade;
    public ?string $uf;
    public ?string $cep;

    public function __construct(
        ?string $nome = null,
        ?string $cpf = null,
        ?string $cnpj = null,
        ?string $email = null,
        ?string $logradouro = null,
        ?string $cidade = null,
        ?string $uf = null,
        ?string $cep = null
    ) {
        $this->nome = $nome;

        if ($cpf) {
            $this->cpf = preg_replace('/\D/', '', $cpf);
            Validator::validateCpf($this->cpf);
        } else {
            $this->cpf = null;
        }

        if ($cnpj) {
            $this->cnpj = preg_replace('/\D/', '', $cnpj);
            Validator::validateCnpj($this->cnpj);
        } else {
            $this->cnpj = null;
        }

        $this->email = $email;
        $this->logradouro = $logradouro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->cep = $cep ? preg_replace('/\D/', '', $cep) : null;
    }

    public function toArray(): array
    {
        return array_filter([
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'logradouro' => $this->logradouro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'cep' => $this->cep,
        ], fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nome'] ?? null,
            $data['cpf'] ?? null,
            $data['cnpj'] ?? null,
            $data['email'] ?? null,
            $data['logradouro'] ?? null,
            $data['cidade'] ?? null,
            $data['uf'] ?? null,
            $data['cep'] ?? null
        );
    }
}
