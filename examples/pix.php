<?php

use LeandroNunes\C6Bank\C6Bank;
use LeandroNunes\C6Bank\DTOs\Pix\CalendarioDTO;
use LeandroNunes\C6Bank\DTOs\Pix\CobDTO;
use LeandroNunes\C6Bank\DTOs\Pix\DevedorDTO;
use LeandroNunes\C6Bank\DTOs\Pix\ValorDTO;

require __DIR__ . '/../vendor/autoload.php';

// Config
$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => 'path/to/cert.pem',
    'private_key' => 'path/to/key.pem',
    'sandbox' => true,
]);

// 1. Create Cobrança Imediata (Cob)
$cobData = new CobDTO(
    calendario: new CalendarioDTO(expiracao: 3600),
    valor: new ValorDTO(original: '123.45'),
    chave: 'CHAVE-PIX-AQUI',
    devedor: new DevedorDTO(
        nome: 'João Silva',
        cpf: '12345678900'
    ),
    solicitacaoPagador: 'Pagamento referente ao pedido #1234'
);

try {
    echo "Creating PIX Cob...\n";
    // $cob = $c6->pix()->cob()->create($cobData);
    // echo "TxId: {$cob->txid}\n";
    // echo "Copy/Paste Code: {$cob->location}\n";

    // Dump for visualization
    print_r($cobData->toArray());

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

// 2. Lote Cobrança (Batch)
// $loteId = 'YOUR_BATCH_ID';
// $loteData = new \LeandroNunes\C6Bank\DTOs\Pix\LoteDTO(
//     cobsv: [
//          new CobvDTO(...),
//          new CobvDTO(...)
//     ],
//     descricao: 'Lote de Mensalidades'
// );
// $c6->pix()->lote()->create($loteId, $loteData);


// 3. Webhook
try {
    echo "\nConfiguring Webhook...\n";
    // $c6->pix()->webhook()->config('CHAVE-PIX-AQUI', 'https://meusite.com/webhook');
    echo "Webhook configured (simulated).\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
