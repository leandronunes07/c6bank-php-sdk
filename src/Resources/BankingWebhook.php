<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\Banking\WebhookConfigDTO;

class BankingWebhook extends Resource
{
    /**
     * Register a new webhook for a banking service (BANK_SLIP, CHECKOUT, etc.)
     *
     * @param string $url The callback URL
     * @param string $service Service name (e.g., 'BANK_SLIP', 'CHECKOUT')
     * @return void
     */
    public function register(string $url, string $service): void
    {
        $payload = [
            'url' => $url,
            'service' => $service,
        ];

        // POST /v1/webhooks
        $this->client->post('/webhooks', $payload);
    }

    /**
     * List configured webhooks for a service
     *
     * @param string $service
     * @return WebhookConfigDTO[]
     */
    public function list(string $service): array
    {
        // GET /v1/webhooks?service=...
        $response = $this->client->get('/webhooks', ['service' => $service]);

        // Response is usually a list of webhooks
        $webhooks = [];
        foreach ($response as $item) {
            $webhooks[] = WebhookConfigDTO::fromArray($item);
        }

        return $webhooks;
    }

    /**
     * Delete webhooks for a service
     *
     * @param string $service
     * @return void
     */
    public function delete(string $service): void
    {
        // DELETE /v1/webhooks?service=...
        $this->client->delete('/webhooks', ['service' => $service]);
    }
}
