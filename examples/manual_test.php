<?php

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\Exceptions\C6BankException;

require __DIR__ . '/../vendor/autoload.php';

$configFile = __DIR__ . '/../config.php';

if (!file_exists($configFile)) {
    die("Error: config.php not found. Please copy config.php.example to config.php and fill in your credentials.\n");
}

$config = require $configFile;

try {
    echo "Initializing C6 Bank Client...\n";
    $c6 = new C6Bank($config);

    echo "Testing Pix Location Creation (v2)...\n";
    $location = $c6->pix()->location()->create('cob');

    echo "Location Created: {$location->location} (ID: {$location->id})\n";

} catch (C6BankException $e) {
    echo "C6Bank SDK Error: " . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo "Caused by: " . $e->getPrevious()->getMessage() . "\n";
    }
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
