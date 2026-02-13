<?php

namespace LeandroNunes\C6Bank\DTOs\Pix;

use LeandroNunes\C6Bank\DTOs\DTOInterface;

class CobvDTO implements DTOInterface
{
    public CalendarioDTO $calendario;
    public DevedorDTO $devedor; // Required for CobV
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
        DevedorDTO $devedor,
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
        $this->txid = $txid;
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
            'devedor' => $this->devedor->toArray(),
            'solicitacaoPagador' => $this->solicitacaoPagador,
        ];

        if ($this->infoAdicionais) {
            $data['infoAdicionais'] = array_map(fn ($info) => $info->toArray(), $this->infoAdicionais);
        }

        // Output fields
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
            DevedorDTO::fromArray($data['devedor'] ?? []),
            $data['solicitacaoPagador'] ?? null,
            $infoAdicionais,
            $data['txid'] ?? null,
            $data['status'] ?? null,
            $data['location'] ?? null,
            $data['revisao'] ?? null
        );
    }
}
