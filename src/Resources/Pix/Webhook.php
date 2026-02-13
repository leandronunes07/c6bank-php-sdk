<?php

namespace LeandroNunes\C6Bank\Resources\Pix;

use LeandroNunes\C6Bank\DTOs\Pix\WebhookDTO;
use LeandroNunes\C6Bank\Resources\Resource;

class Webhook extends Resource
{
    public function config(string $chave, string $webhookUrl): void
    {
        $this->client->put("/pix/webhook/{$chave}", ['webhookUrl' => $webhookUrl]);
    }

    public function get(string $chave): WebhookDTO
    {
        $response = $this->client->get("/pix/webhook/{$chave}");

        return WebhookDTO::fromArray($response);
    }

    public function delete(string $chave): void
    {
        $this->client->delete("/pix/webhook/{$chave}");
    }

    public function list(): array
    {
        return $this->client->get("/pix/webhook");
    }
}
