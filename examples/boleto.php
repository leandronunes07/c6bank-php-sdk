<?php

require __DIR__ . '/../vendor/autoload.php';

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\BankSlip\AddressDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\BankSlipDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\PayerDTO;

// Load env or hardcode
$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => 'path/to/cert.pem',
    'private_key' => 'path/to/key.pem',
    'sandbox' => true,
]);

// 1. Prepare Data
$address = new AddressDTO(
    street: 'Av. Paulista',
    number: '1000',
    neighborhood: 'Bela Vista',
    city: 'São Paulo',
    state: 'SP',
    zipCode: '01310-100'
);

$payer = new PayerDTO(
    name: 'Leandro Nunes',
    document: '123.456.789-00',
    address: $address
);

$boletoData = new BankSlipDTO(
    amount: 150.00,
    dueDate: '2024-12-31',
    payer: $payer,
    yourNumber: 'PEDIDO-1001'
);

try {
    echo "Creating Bank Slip...\n";
    // $boleto = $c6->bankSlips()->create($boletoData);
    // echo "Boleto Created! ID: {$boleto->id}\n";
    // echo "BarCode: {$boleto->barCode}\n";

    echo "Simulating success object dump:\n";
    print_r($boletoData->toArray());

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
