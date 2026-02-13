<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;
use LeandroNunes\C6Bank\Helpers\Validator;

class CobDTO implements DTOInterface
{
    public CalendarioDTO $calendario;
    public ?DevedorDTO $devedor;
    public ValorDTO $valor;
    public string $chave;
    public ?string $solicitacaoPagador;

    /** @var InfoAdicionalDTO[]|null */
    public ?array $infoAdicionais; // Array of InfoAdicionalDTO

    public ?string $txid;
    public ?string $status;
    public ?string $location; // URL do payload
    public ?int $revisao;

    public function __construct(
        CalendarioDTO $calendario,
        ValorDTO $valor,
        string $chave,
        ?DevedorDTO $devedor = null,
        ?string $solicitacaoPagador = null,
        ?array $infoAdicionais = null,
        ?string $txid = null,
        ?string $status = null,
        ?string $location = null,
        ?int $revisao = null
    ) {
        $this->calendario = $calendario;
        $this->valor = $valor;
        $this->chave = $chave;
        $this->devedor = $devedor;
        $this->solicitacaoPagador = $solicitacaoPagador;
        $this->infoAdicionais = $infoAdicionais;

        if ($txid) {
            Validator::validateTxId($txid);
            $this->txid = $txid;
        } else {
            $this->txid = null;
        }

        $this->status = $status;
        $this->location = $location;
        $this->revisao = $revisao;
    }

    public function toArray(): array
    {
        $data = [
            'calendario' => $this->calendario->toArray(),
            'valor' => $this->valor->toArray(),
            'chave' => $this->chave,
            'solicitacaoPagador' => $this->solicitacaoPagador,
        ];

        if ($this->devedor) {
            $data['devedor'] = $this->devedor->toArray();
        }

        if ($this->infoAdicionais) {
            $data['infoAdicionais'] = array_map(fn ($info) => $info->toArray(), $this->infoAdicionais);
        }

        // Output fields present only if not null (usually in response)
        if ($this->txid) {
            $data['txid'] = $this->txid;
        }
        if ($this->status) {
            $data['status'] = $this->status;
        }
        if ($this->location) {
            $data['location'] = $this->location;
        }
        if (!is_null($this->revisao)) {
            $data['revisao'] = $this->revisao;
        }

        return array_filter($data, fn ($value) => !is_null($value));
    }

    public static function fromArray(array $data): self
    {
        $infoAdicionais = [];
        if (isset($data['infoAdicionais']) && is_array($data['infoAdicionais'])) {
            $infoAdicionais = array_map(fn ($item) => InfoAdicionalDTO::fromArray($item), $data['infoAdicionais']);
        }

        return new self(
            CalendarioDTO::fromArray($data['calendario'] ?? []),
            ValorDTO::fromArray($data['valor'] ?? []),
            $data['chave'] ?? '',
            isset($data['devedor']) ? DevedorDTO::fromArray($data['devedor']) : null,
            $data['solicitacaoPagador'] ?? null,
            $infoAdicionais,
            $data['txid'] ?? null,
            $data['status'] ?? null,
            $data['location'] ?? null,
            $data['revisao'] ?? null
        );
    }
}
