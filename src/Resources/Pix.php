<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\Http\Client;
use LeandroNunes\C6Bank\Resources\Pix\Cob;
use LeandroNunes\C6Bank\Resources\Pix\CobV;
use LeandroNunes\C6Bank\Resources\Pix\Location;
use LeandroNunes\C6Bank\Resources\Pix\Lote;
use LeandroNunes\C6Bank\Resources\Pix\Webhook;

class Pix
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function cob(): Cob
    {
        return new Cob($this->client);
    }

    public function cobv(): CobV
    {
        return new CobV($this->client);
    }

    public function lote(): Lote
    {
        return new Lote($this->client);
    }

    public function location(): Location
    {
        return new Location($this->client);
    }

    public function webhook(): Webhook
    {
        return new Webhook($this->client);
    }
}
