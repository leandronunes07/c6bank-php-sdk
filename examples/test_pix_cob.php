<?php

require __DIR__ . '/../vendor/autoload.php';

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\Pix\CalendarioDTO;
use LeandroNunes\C6Bank\DTOs\Pix\CobDTO;
use LeandroNunes\C6Bank\DTOs\Pix\DevedorDTO;
use LeandroNunes\C6Bank\DTOs\Pix\ValorDTO;
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

    echo "Preparando dados do Pix Cob (v2)...\n";

    // Dados fictícios
    $calendario = new CalendarioDTO(3600); // Expira em 1 hora
    $valor = new ValorDTO('1.50');
    $chave = '+5511999999999'; // Chave Aleatória (ou use a do config se disponível, mas aqui hardcoded para exemplo)
    // Na prática, a chave deve ser uma chave válida cadastrada na conta.
    // Vamos tentar usar uma chave que provavelmente não existe para ver o erro ou sucesso se for sandbox.
    // Melhor: usar uma chave EVP gerada ou CPF.
    $chave = '00000000000'; // CPF Inválido propositalmente? Não, vamos tentar um formato válido.

    // No Sandbox, qualquer chave costuma funcionar ou precisa ser criada antes.
    // Vamos assumir que o usuário tem uma chave válida.
    // Se falhar, o erro nos dirá.

    // Gerar txid aleatório (26 a 35 caracteres alfanuméricos)
    $txid = bin2hex(random_bytes(16)); // 32 chars

    $devedor = new DevedorDTO(
        'Fulano Pagador',
        '12345678909' // CPF
    );

    $cob = new CobDTO(
        $calendario,
        $valor,
        $chave,
        $devedor,
        'Pagamento Exemplo'
    );

    echo "Enviando requisição de criação (txid: $txid)...\n";
    $createdCob = $c6->pix()->cob()->create($cob, $txid);

    echo "Sucesso!\n";
    echo "TxId: " . $createdCob->txid . "\n";
    echo "Location: " . $createdCob->location . "\n";
    echo "Copia e Cola: " . ($createdCob->pixCopiaECola ?? 'N/A') . "\n";

} catch (C6BankException $e) {
    echo "Erro C6Bank SDK: " . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo "Causa: " . $e->getPrevious()->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "Erro Geral: " . $e->getMessage() . "\n";
}
