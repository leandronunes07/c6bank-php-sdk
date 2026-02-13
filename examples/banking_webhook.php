<?php

use LeandroNunes\C6Bank\C6Bank;

require __DIR__ . '/../vendor/autoload.php';

$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => 'path/to/cert.pem',
    'private_key' => 'path/to/key.pem',
    'sandbox' => true,
]);

try {
    echo "Registering Boleto Webhook...\n";
    $c6->bankingWebhook()->register('https://mysite.com/callbacks/boleto', 'BANK_SLIP');
    echo "Registered!\n";

    echo "Registering Checkout Webhook...\n";
    $c6->bankingWebhook()->register('https://mysite.com/callbacks/checkout', 'CHECKOUT');
    echo "Registered!\n";

    echo "Listing Boleto Webhooks...\n";
    $webhooks = $c6->bankingWebhook()->list('BANK_SLIP');
    foreach ($webhooks as $webhook) {
        echo "- Service: {$webhook->service}, URL: {$webhook->url}\n";
    }

    // echo "Deleting Checkout Webhooks...\n";
    // $c6->bankingWebhook()->delete('CHECKOUT');
    // echo "Deleted.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
