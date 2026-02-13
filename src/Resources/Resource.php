<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\Http\Client;

abstract class Resource
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
