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
    echo "Decoding Barcode...\n";
    $lineCode = '34191.79001 01043.510047 91020.150008 5 84410000010000';
    $decoded = $c6->schedule()->decode($lineCode);

    echo "Bank: {$decoded->bankName}\n";
    echo "Value: {$decoded->amount}\n";
    echo "Beneficiary: {$decoded->beneficiaryName}\n";

    echo "Querying DDA/Schedule...\n";
    $scheduled = $c6->schedule()->query();
    print_r($scheduled);

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
