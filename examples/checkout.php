<?php

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\Checkout\CheckoutDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PayerDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PaymentSettingsDTO;

require __DIR__ . '/../vendor/autoload.php';

$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => 'path/to/cert.pem',
    'private_key' => 'path/to/key.pem',
    'sandbox' => true,
]);

$checkoutData = new CheckoutDTO(
    amount: 150.00,
    description: 'Pedido #12345 - Loja Virtual',
    externalReferenceId: 'ORDER-12345',
    payer: new PayerDTO(
        name: 'Fulano de Tal',
        taxId: '12345678900',
        email: 'fulano@email.com',
        address: [
            'street' => 'Av. Paulista',
            'number' => 1000,
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '01310100',
        ]
    ),
    payment: new PaymentSettingsDTO(
        card: ['authenticate' => 'NOT_REQUIRED', 'capture' => true],
        pix: ['key' => 'AUTO'] // 'AUTO' gera uma chave aleatória/dinâmica para o checkout
    ),
    redirectUrl: 'https://minhaloja.com/pedido/sucesso'
);

try {
    echo "Creating Checkout...\n";
    $checkout = $c6->checkout()->create($checkoutData);
    echo "Checkout created!\n";
    echo "ID: {$checkout->id}\n";
    echo "Status: {$checkout->status}\n";
    echo "Payment URL: {$checkout->paymentUrl}\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
