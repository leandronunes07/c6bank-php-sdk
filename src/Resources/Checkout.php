<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\Checkout\CheckoutDTO;

class Checkout extends Resource
{
    /**
     * Criar um novo Checkout
     *
     * @param CheckoutDTO $checkout
     * @return CheckoutDTO
     */
    public function create(CheckoutDTO $checkout): CheckoutDTO
    {
        $payload = $checkout->toArray();
        // POST /v1/checkouts
        $response = $this->client->post('/checkouts', $payload);

        return CheckoutDTO::fromArray($response);
    }

    /**
     * Consultar um Checkout
     *
     * @param string $id
     * @return CheckoutDTO
     */
    public function get(string $id): CheckoutDTO
    {
        // GET /v1/checkouts/{id}
        $response = $this->client->get("/checkouts/{$id}");

        return CheckoutDTO::fromArray($response);
    }

    /**
     * Cancelar um Checkout
     *
     * @param string $id
     * @return bool
     */
    public function cancel(string $id): bool
    {
        // PUT /v1/checkouts/{id}/cancel
        $this->client->put("/checkouts/{$id}/cancel");

        return true;
    }

    /**
     * Autorizar/Capturar um pagamento de Checkout (se configurado para não capturar automático)
     *
     * @param CheckoutDTO $checkout (Necessário enviar o objeto com as informações de captura, ou parte dele)
     * @return CheckoutDTO
     */
    public function authorize(CheckoutDTO $checkout): CheckoutDTO
    {
        // POST /v1/checkouts/authorize
        // O body geralmente precisa dos dados da transação/card para autorizar se for manual.
        // Pelo postman: payload igual ao de create.
        $payload = $checkout->toArray();
        $response = $this->client->post("/checkouts/authorize", $payload);

        return CheckoutDTO::fromArray($response);
    }
}
