<?php

namespace LeandroNunes\C6Bank\Resources\Pix;

use LeandroNunes\C6Bank\DTOs\Pix\LoteDTO;
use LeandroNunes\C6Bank\Resources\Resource;

class Lote extends Resource
{
    /**
     * Criar ou Alterar Lote de Cobranças (CobV)
     *
     * @param string $idLote ID do lote (único gerado pelo cliente)
     * @param LoteDTO $lote
     * @return LoteDTO
     */
    public function create(string $idLote, LoteDTO $lote): LoteDTO
    {
        $payload = $lote->toArray();
        // PUT /v2/pix/lotecobv/{id}
        $response = $this->client->put("/v2/pix/lotecobv/{$idLote}", $payload);

        return LoteDTO::fromArray($response);
    }

    /**
     * Revisar Lote (Atualizar)
     *
     * @param string $idLote
     * @param LoteDTO $lote
     * @return LoteDTO
     */
    public function update(string $idLote, LoteDTO $lote): LoteDTO
    {
        $payload = $lote->toArray();
        // PATCH /v2/pix/lotecobv/{id}
        $response = $this->client->patch("/v2/pix/lotecobv/{$idLote}", $payload);

        return LoteDTO::fromArray($response);
    }

    /**
     * Consultar Lote
     *
     * @param string $idLote
     * @return LoteDTO
     */
    public function get(string $idLote): LoteDTO
    {
        $response = $this->client->get("/v2/pix/lotecobv/{$idLote}");

        return LoteDTO::fromArray($response);
    }

    /**
     * Listar Lotes
     *
     * @param array $filters (inicio, fim, paginacao...)
     * @return array
     */
    public function list(array $filters = []): array
    {
        // GET /v2/pix/lotecobv
        return $this->client->get("/v2/pix/lotecobv", $filters);
    }
}
