<?php

namespace LeandroNunes\C6Bank\Resources\Pix;

use LeandroNunes\C6Bank\DTOs\Pix\CobvDTO;
use LeandroNunes\C6Bank\Resources\Resource;

class CobV extends Resource
{
    /**
     * Criar Cobrança com Vencimento
     *
     * @param string $txid
     * @param CobvDTO $cobv
     * @return CobvDTO
     */
    public function create(string $txid, CobvDTO $cobv): CobvDTO
    {
        $payload = $cobv->toArray();
        $response = $this->client->put("/pix/cobv/{$txid}", $payload);

        return CobvDTO::fromArray($response);
    }

    /**
     * Consultar Cobrança com Vencimento
     *
     * @param string $txid
     * @return CobvDTO
     */
    public function get(string $txid): CobvDTO
    {
        $response = $this->client->get("/pix/cobv/{$txid}");

        return CobvDTO::fromArray($response);
    }

    /**
     * Revisar Cobrança (Atualizar)
     *
     * @param string $txid
     * @param CobvDTO $cobv
     * @return CobvDTO
     */
    public function update(string $txid, CobvDTO $cobv): CobvDTO
    {
        $payload = $cobv->toArray();
        $response = $this->client->patch("/pix/cobv/{$txid}", $payload);

        return CobvDTO::fromArray($response);
    }
}
