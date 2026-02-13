<?php

namespace LeandroNunes\C6Bank\Resources\Pix;

use LeandroNunes\C6Bank\DTOs\Pix\LocationDTO;
use LeandroNunes\C6Bank\Resources\Resource;

class Location extends Resource
{
    public function create(string $type = 'cob'): LocationDTO
    {
        $response = $this->client->post("/v2/pix/loc", ['tipoCob' => $type]);

        return LocationDTO::fromArray($response); // Returns id, location, tipoCob, criacao
    }

    public function get(string $id): LocationDTO
    {
        $response = $this->client->get("/v2/pix/loc/{$id}");

        return LocationDTO::fromArray($response);
    }

    public function getPayLoad(string $id): string
    {
        // The endpoint to get the payload (txid associated)
        return $this->get($id)->location ?? '';
    }

    public function unlink(string $id): void
    {
        $this->client->delete("/v2/pix/loc/{$id}/txid");
    }
}
