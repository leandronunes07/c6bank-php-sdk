<?php

namespace LeandroNunes\C6Bank\Resources\Pix;

use LeandroNunes\C6Bank\DTOs\Pix\CobDTO;
use LeandroNunes\C6Bank\Resources\Resource;

class Cob extends Resource
{
    /**
     * Criar Cobrança Imediata
     *
     * @param CobDTO $cob
     * @param string|null $txid
     * @return CobDTO
     */
    public function create(CobDTO $cob, ?string $txid = null): CobDTO
    {
        $payload = $cob->toArray();

        if ($txid) {
            $response = $this->client->put("/v2/pix/cob/{$txid}", $payload);
        } else {
            $response = $this->client->post("/v2/pix/cob", $payload);
        }

        return CobDTO::fromArray($response);
    }

    /**
     * Consultar Cobrança Imediata
     *
     * @param string $txid
     * @return CobDTO
     */
    public function get(string $txid): CobDTO
    {
        $response = $this->client->get("/v2/pix/cob/{$txid}");

        return CobDTO::fromArray($response);
    }

    /**
     * Revisar Cobrança (Atualizar)
     *
     * @param string $txid
     * @param CobDTO $cob
     * @return CobDTO
     */
    public function update(string $txid, CobDTO $cob): CobDTO
    {
        // PATCH usually requires only fields to be updated.
        // For now, sending full array minus nulls (filtered in DTO).
        // Important: 'chave' usually immutable.
        $payload = $cob->toArray();

        $response = $this->client->patch("/v2/pix/cob/{$txid}", $payload);

        return CobDTO::fromArray($response);
    }
}
