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
    // 1. Bank Statement
    echo "Fetching Account Statement...\n";
    $statements = $c6->statement()->get('2025-01-01', '2025-01-31');

    foreach ($statements as $item) {
        echo "{$item->date} | {$item->description} | {$item->amount}\n";
    }

    // 2. C6 Pay (Acquiring)
    echo "\nFetching C6 Pay Receivables...\n";
    $receivables = $c6->c6pay()->receivables('2025-01-01');

    foreach ($receivables as $rec) {
        echo "{$rec->date} | {$rec->netAmount} | {$rec->status}\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
