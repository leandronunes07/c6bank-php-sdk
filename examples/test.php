<?php

require __DIR__ . '/../vendor/autoload.php';

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\Exceptions\C6BankException;

// Load env or just hardcode for example (better not to hardcode credentials)
$clientId = getenv('C6_CLIENT_ID') ?: 'your-client-id';
$clientSecret = getenv('C6_CLIENT_SECRET') ?: 'your-client-secret';
$certPath = getenv('C6_CERT_PATH') ?: '/path/to/cert.pem';
$keyPath = getenv('C6_KEY_PATH') ?: '/path/to/key.pem';

$c6 = new C6Bank([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'certificate' => $certPath,
    'private_key' => $keyPath,
    'sandbox' => true,
]);

try {
    echo "Authenticating...\n";
    // This will trigger auth internally on first request

    echo "Getting accounts...\n";
    // This will fail without real credentials, but shows usage
    $accounts = $c6->accounts()->listAccounts();

    foreach ($accounts as $account) {
        echo "Account ID: {$account->id}, Balance: {$account->balance}\n";
    }

} catch (C6BankException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
