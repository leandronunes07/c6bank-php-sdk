<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\C6Pay\C6PayItemDTO;

class C6Pay extends Resource
{
    /**
     * Consultar Recebíveis (Vendas consolidadas)
     *
     * @param string $startDate YYYY-MM-DD
     * @param int $page
     * @return C6PayItemDTO[]
     */
    public function receivables(string $startDate, int $page = 1): array
    {
        // GET /v1/c6pay/statement/receivables
        $query = [
            'start_date' => $startDate,
            'page' => $page,
        ];

        $response = $this->client->get('/v1/c6pay/statement/receivables', $query);

        $items = [];
        $data = $response['items'] ?? $response;

        if (is_array($data)) {
            foreach ($data as $item) {
                $items[] = C6PayItemDTO::fromArray($item);
            }
        }

        return $items;
    }

    /**
     * Consultar Transações (Vendas detalhadas)
     *
     * @param string $startDate YYYY-MM-DD
     * @param int $page
     * @return C6PayItemDTO[]
     */
    public function transactions(string $startDate, int $page = 1): array
    {
        // GET /v1/c6pay/statement/transactions
        $query = [
            'start_date' => $startDate,
            'page' => $page,
        ];

        $response = $this->client->get('/v1/c6pay/statement/transactions', $query);

        $items = [];
        $data = $response['items'] ?? $response;

        if (is_array($data)) {
            foreach ($data as $item) {
                $items[] = C6PayItemDTO::fromArray($item);
            }
        }

        return $items;
    }
}
