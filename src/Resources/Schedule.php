<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\Schedule\DecodedBoletoDTO;

class Schedule extends Resource
{
    /**
     * Decode a line code (barcode/digitable line)
     *
     * @param string $lineCode
     * @return DecodedBoletoDTO
     */
    public function decode(string $lineCode): DecodedBoletoDTO
    {
        // Based on Postman "Enviar um grupo de pagtos para consulta inicial" (decode)
        // It sends a list of items to decode. For simplicity, we decode one by one here or wrap it.
        // The endpoint is /v1/schedule_payments/decode
        // Body: { "items": [ { "content": "LINE_CODE", ... } ] }

        $payload = [
            'items' => [
                [
                    'content' => $lineCode,
                    // Other fields are optional or for return
                ],
            ],
        ];

        $response = $this->client->post('/schedule_payments/decode', $payload);

        // Response should contain the decoded item
        $item = $response['items'][0] ?? [];

        return DecodedBoletoDTO::fromArray($item);
    }

    /**
     * Query scheduled payments (DDA/Pending)
     *
     * @return array
     */
    public function query(): array
    {
        // GET /v1/schedule_payments/query
        return $this->client->get('/schedule_payments/query');
    }

    /**
     * Get items from a payment group
     *
     * @param string $groupId
     * @return array
     */
    public function items(string $groupId): array
    {
        // GET /v1/schedule_payments/{group_id}/items
        return $this->client->get("/schedule_payments/{$groupId}/items");
    }

    /**
     * Delete a specific item from a group
     *
     * @param string $groupId
     * @param string $itemId
     * @return void
     */
    public function deleteItem(string $groupId, string $itemId): void
    {
        // DELETE /v1/schedule_payments/{group_id}/items/{item_id}
        $this->client->delete("/schedule_payments/{$groupId}/items/{$itemId}");
    }
}
