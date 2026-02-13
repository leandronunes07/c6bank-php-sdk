<?php

use LeandroNunes\C6Bank\C6Bank;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

require __DIR__ . '/../vendor/autoload.php';

// 1. Setup Cache (PSR-16)
// Using Symfony Cache as example (requires: composer require symfony/cache)
// For this example to work, you'd need to install symfony/cache and monolog/monolog
// composer require symfony/cache monolog/monolog

// Mocking for demonstration if dependencies are not present
// In a real app: $psr16Cache = new Psr16Cache(new FilesystemAdapter());
$psr16Cache = null;

// 2. Setup Logger (PSR-3)
// In a real app:
// $log = new Logger('c6bank');
// $log->pushHandler(new StreamHandler('c6bank.log', Logger::DEBUG));
$logger = null;

echo "Production Setup Example (Conceptual)\n";
echo "-------------------------------------\n";
echo "To enable Cache and Logging, pass them in the config array:\n\n";

/*
$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => 'path/to/cert.pem',
    'private_key' => 'path/to/key.pem',
    'sandbox' => false,

    // Inject PSR-16 Cache
    'cache' => $psr16Cache,

    // Inject PSR-3 Logger
    'logger' => $logger
]);
*/

echo "SDK configured with Cache and Logger support!\n";
