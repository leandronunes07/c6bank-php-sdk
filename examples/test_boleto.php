<?php

require __DIR__ . '/../vendor/autoload.php';

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\BankSlip\AddressDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\BankSlipDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\PayerDTO;
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

    echo "Preparando dados do Boleto (v1)...\n";

    // Dados fictícios para teste em Sandbox
    $address = new AddressDTO(
        'Av. Paulista',
        '1000',
        'Bela Vista',
        'São Paulo',
        'SP',
        '01310100'
    );

    $payer = new PayerDTO(
        'Fulano de Tal',
        '52998224725', // CPF Válido
        $address
    );

    $dueDate = '2026-02-10'; // Trocando para D-1 (se D é 11/02)
    $bankSlip = new BankSlipDTO(
        100.50, // Valor
        $dueDate,
        $payer,
        "TEST" . rand(100, 999) // Valid alphanumeric 1-10 chars
    );

    echo "Enviando requisição de criação...\n";
    $createdBankSlip = $c6->bankSlips()->create($bankSlip);

    echo "Sucesso!\n";
    echo "ID do Boleto: " . $createdBankSlip->id . "\n";
    echo "Linha Digitável: " . $createdBankSlip->digitableLine . "\n";
    echo "PDF URL: " . $createdBankSlip->pdfUrl . "\n";

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
