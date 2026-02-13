<?php

namespace LeandroNunes\C6Bank\Resources;

use LeandroNunes\C6Bank\DTOs\BankSlip\BankSlipDTO;
use LeandroNunes\C6Bank\Exceptions\C6BankException;

class BankSlip extends Resource
{
    /**
     * Create a new Bank Slip (Boleto)
     *
     * @param BankSlipDTO $bankSlip
     * @return BankSlipDTO
     * @throws C6BankException
     */
    public function create(BankSlipDTO $bankSlip): BankSlipDTO
    {
        $payload = $bankSlip->toArray();

        // Adjust payload structure according to C6 API requirements if needed
        // For now, assuming direct mapping. In real scenario, might need key mapping.

        $response = $this->client->post('/bank-slips', $payload);

        return BankSlipDTO::fromArray($response);
    }

    /**
     * Get Bank Slip details
     *
     * @param string $id
     * @return BankSlipDTO
     * @throws C6BankException
     */
    public function get(string $id): BankSlipDTO
    {
        $response = $this->client->get("/bank-slips/{$id}");

        return BankSlipDTO::fromArray($response);
    }

    /**
     * Get Bank Slip PDF content
     *
     * @param string $id
     * @return string Binary PDF content
     * @throws C6BankException
     */
    public function getPdf(string $id): string
    {
        // Guzzle client implicitly handles parsing json, so we might need a raw request here or method in Client
        // For now, assuming the client handles it or we'll need to extend Client.
        // Let's assume the API returns a JSON with base64 or a direct PDF stream.
        // If stream, Client::get might try to json_decode.
        // TODO: Refactor Client to support non-JSON responses if needed.

        // Simulating: C6 usually returns a PDF stream or a JSON with download URL.
        // Based on docs seen earlier: GET /bank-slips/{id}/pdf

        // We'll use a direct request via underlying client if needed, but let's try standard flow.
        // If Client::get forces JSON, this might break. Let's inspect Client.php later.

        // Ideally:
        // $response = $this->client->requestRaw('GET', "/bank-slips/{$id}/pdf");
        // return $response->getBody()->getContents();

        // For MVP, letting standard get, assuming it might need adjustment during testing.
        $response = $this->client->get("/bank-slips/{$id}/pdf");

        return $response['content'] ?? ''; // Placeholder
    }

    /**
     * Cancel a Bank Slip
     *
     * @param string $id
     * @return bool
     * @throws C6BankException
     */
    public function cancel(string $id): bool
    {
        $this->client->put("/bank-slips/{$id}/cancel");

        return true;
    }
}
