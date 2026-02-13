<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\Statement\StatementItemDTO;

class Statement extends Resource
{
    /**
     * Consultar Extrato Bancário
     *
     * @param string $startDate YYYY-MM-DD
     * @param string $endDate YYYY-MM-DD
     * @param int $page
     * @return StatementItemDTO[]
     */
    public function get(string $startDate, string $endDate, int $page = 1): array
    {
        // GET /v1/statement
        $query = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'page' => $page,
        ];

        $response = $this->client->get('/v1/statement', $query);

        $items = [];
        $data = $response['items'] ?? $response; // Fallback

        if (is_array($data)) {
            foreach ($data as $item) {
                $items[] = StatementItemDTO::fromArray($item);
            }
        }

        return $items;
    }
}
