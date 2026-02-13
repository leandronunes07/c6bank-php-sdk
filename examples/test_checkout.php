<?php

require __DIR__ . '/../vendor/autoload.php';

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\Checkout\CheckoutDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PayerDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PaymentSettingsDTO;
use LeandroNunes\C6Bank\Exceptions\C6BankException;

$config = [];
if (file_exists(__DIR__ . '/../config.php')) {
    $config = require __DIR__ . '/../config.php';
} else {
    die("Arquivo config.php não encontrado. Copie config.php.example para config.php e preencha as credenciais.\n");
}

try {
    echo "Inicializando Cliente C6 Bank...\n";
    $c6 = new C6Bank($config);

    echo "Preparando dados do Checkout (v1)...\n";

    // Dados fictícios
    $payer = new PayerDTO(
        'Comprador Exemplo',
        '52998224725', // CPF Válido
        'comprador@example.com'
    );

    $paymentSettings = new PaymentSettingsDTO(
        null, // Card settings (optional)
        [
            'key' => 'AUTO' // Enum requirement
        ]
    );

    $checkout = new CheckoutDTO(
        50.00, // Amount
        'Compra de Teste', // Description
        'TESTCHK', // External Ref (Max 10 chars)
        $payer,
        $paymentSettings
    );

    echo "Enviando requisição de criação...\n";
    $createdCheckout = $c6->checkout()->create($checkout);

    echo "Sucesso!\n";
    echo "ID do Checkout: " . $createdCheckout->id . "\n";
    echo "URL de Pagamento: " . $createdCheckout->paymentUrl . "\n";
    echo "Status: " . $createdCheckout->status . "\n";

} catch (C6BankException $e) {
    echo "Erro C6Bank SDK: " . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo "Causa: " . $e->getPrevious()->getMessage() . "\n";
        if (method_exists($e->getPrevious(), 'getResponse') && $e->getPrevious()->getResponse()) {
            echo "Body: " . $e->getPrevious()->getResponse()->getBody()->getContents() . "\n";
        }
    }
} catch (Exception $e) {
    echo "Erro Geral: " . $e->getMessage() . "\n";
}
