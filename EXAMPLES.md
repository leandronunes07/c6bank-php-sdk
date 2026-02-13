# Usage Examples - C6 Bank PHP SDK

Below are practical examples of how to use each SDK resource.

## Initial Configuration

```php
use LeandroNunes\C6Bank\C6Bank;

$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => '/path/to/cert.pem', // Optional (mTLS)
    'private_key' => '/path/to/key.pem',   // Optional (mTLS)
    'sandbox' => true // true for sandbox environment
]);
```

## 🏦 Current Account

### Get Balance and Account Data

```php
try {
    // Returns an AccountDTO object
    $account = $c6->accounts()->getAccount('account-id');

    echo "Account: {$account->name}\n";
    echo "Balance: {$account->currency} {$account->balance}\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### List Accounts

```php
$accounts = $c6->accounts()->listAccounts();

foreach ($accounts as $acc) {
    echo "ID: {$acc->id} - Balance: {$acc->balance}\n";
}
```

## 📝 Bank Slips (Boleto)

### Create a Bank Slip

```php
use LeandroNunes\C6Bank\DTOs\BankSlip\AddressDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\PayerDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\BankSlipDTO;

// 1. Define Address
$address = new AddressDTO(
    street: 'Av. Paulista',
    number: '1000',
    neighborhood: 'Bela Vista',
    city: 'São Paulo',
    state: 'SP',
    zipCode: '01310-100'
);

// 2. Define Payer
$payer = new PayerDTO(
    name: 'John Doe',
    document: '123.456.789-00',
    address: $address
);

// 3. Define Bank Slip
$boletoData = new BankSlipDTO(
    amount: 150.00,
    dueDate: '2024-12-31',
    payer: $payer,
    yourNumber: 'ORDER-1001'
);

// 4. Send Request
try {
    $boleto = $c6->bankSlips()->create($boletoData);
    echo "Boleto ID: {$boleto->id}\n";
    echo "BarCode: {$boleto->barCode}\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Consult a Bank Slip

```php
$boleto = $c6->bankSlips()->get('your-boleto-id');
echo "Status: {$boleto->status}";
```

### Download PDF

```php
$pdfContent = $c6->bankSlips()->getPdf('your-boleto-id');
file_put_contents('boleto.pdf', $pdfContent);
```

### Cancel a Bank Slip

```php
$success = $c6->bankSlips()->cancel('your-boleto-id');
if ($success) {
    echo "Boleto cancelled successfully.";
}
```

## 💠 PIX (Instant Payments)

### Create Immediate Charge (Cob)

```php
use LeandroNunes\C6Bank\DTOs\Pix\CalendarioDTO;
use LeandroNunes\C6Bank\DTOs\Pix\CobDTO;
use LeandroNunes\C6Bank\DTOs\Pix\DevedorDTO;
use LeandroNunes\C6Bank\DTOs\Pix\ValorDTO;

$cobData = new CobDTO(
    calendario: new CalendarioDTO(expiracao: 3600),
    valor: new ValorDTO(original: '50.00'),
    chave: 'YOUR_PIX_KEY',
    devedor: new DevedorDTO(
        nome: 'Maria Silva',
        cpf: '98765432100'
    ),
    solicitacaoPagador: 'Service Payment'
);

// Create
$cob = $c6->pix()->cob()->create($cobData);
echo "TxId: {$cob->txid}";
echo "Payload: {$cob->location}";
```

### Consult Charge

```php
$cob = $c6->pix()->cob()->get('txid-here');
echo "Status: {$cob->status}";
```

## 🔔 Webhooks

### Configure PIX Webhook

```php
$c6->pix()->webhook()->config('YOUR_PIX_KEY', 'https://your-domain.com/webhook');
```

### Configure Banking Webhook (Boleto/Checkout)

```php
// Register
$c6->bankingWebhook()->register('https://callback.url', 'BANK_SLIP');
$c6->bankingWebhook()->register('https://callback.url', 'CHECKOUT');

// List
$webhooks = $c6->bankingWebhook()->list('BANK_SLIP');

// Delete
$c6->bankingWebhook()->delete('BANK_SLIP');
```

## 🛒 Checkout (E-commerce)

### Create Checkout Session

```php
use LeandroNunes\C6Bank\DTOs\Checkout\CheckoutDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PayerDTO;
use LeandroNunes\C6Bank\DTOs\Checkout\PaymentSettingsDTO;

$checkoutData = new CheckoutDTO(
    amount: 150.00,
    description: 'Order #12345',
    externalReferenceId: 'ORDER-12345',
    payer: new PayerDTO(
        name: 'John Doe',
        taxId: '12345678900',
        email: 'john@example.com'
    ),
    payment: new PaymentSettingsDTO(pix: ['key' => 'AUTO']),
    redirectUrl: 'https://store.com/success'
);

$checkout = $c6->checkout()->create($checkoutData);
echo "Pay at: {$checkout->paymentUrl}";
```

## 📜 Bank Statement

### Get Account Statement

```php
$statements = $c6->statement()->get('2025-01-01', '2025-01-31');

foreach ($statements as $item) {
    echo "{$item->date} - {$item->description}: {$item->amount}\n";
}
```

## 💳 C6 Pay (Acquiring)

### Get Receivables

```php
$receivables = $c6->c6pay()->receivables('2025-01-01');

foreach ($receivables as $rec) {
    echo "{$rec->date} - Net: {$rec->netAmount} ({$rec->status})\n";
}
```

### Get Transactions

```php
$transactions = $c6->c6pay()->transactions('2025-01-01');
```
