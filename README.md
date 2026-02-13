# C6 Bank PHP SDK 🇧🇷

![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.0.0-orange)
![Code Style](https://img.shields.io/badge/code%20style-PSR--12-black)

**Unofficial PHP SDK for C6 Bank API.**
Simplify your integration with C6 Bank's services using a robust, object-oriented, and production-ready library.

---

## 🌟 Why use this SDK?

Integration with banking APIs can be complex (mTLS, OAuth2, cryptic errors). This SDK abstracts all that complexity into a fluent, easy-to-use interface.

*   **Fluent Interface**: `$c6->pix()->cob()->create(...)`
*   **Strongly Typed**: Input and Output DTOs for IntelliSense and Type Safety.
*   **Production Ready**:
    *   🐢 **Auth Cache**: Prevents Rate Limiting by caching tokens (PSR-16).
    *   🕵️ **Logging**: Debug requests and responses (PSR-3).
    *   🔁 **Resilience**: Auto-retry on network failures or 5xx errors.
    *   🛡️ **Validation**: Fail-fast validation for CPFs, CNPJs, and UUIDs.
*   **Complete**: Support for Boleto, PIX, Webhooks, Checkout, Schedule, Statement, and C6 Pay.

---

## 📦 Installation

Install via Composer:

```bash
composer require leandronunes07/c6bank-php-sdk
```

### Requirements
*   PHP >= 8.1
*   `ext-json`, `ext-curl`
*   `psr/simple-cache`, `psr/log`

---

## ⚡ Quick Start (Simple)

For development/testing:

```php
use LeandroNunes\C6Bank\C6Bank;

$c6 = new C6Bank([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'certificate' => '/path/to/cert.pem', // Required for Production
    'private_key' => '/path/to/key.pem',   // Required for Production
    'sandbox' => true
]);

// 1. Get Account Balance
try {
    $account = $c6->accounts()->getAccount('account-id');
    echo "Balance: {$account->balance}";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## 🏭 Production Setup (Recommended)

For production, you should inject a **Cache** (to store tokens) and a **Logger** (to debug errors).

```php
use LeandroNunes\C6Bank\C6Bank;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// 1. Setup PSR-16 Cache (Example with Symfony Cache)
$cache = new RedisAdapter($redisConnection); // or FilesystemAdapter

// 2. Setup PSR-3 Logger (Example with Monolog)
$logger = new Logger('c6bank');
$logger->pushHandler(new StreamHandler('configs/c6bank.log', Logger::WARNING));

// 3. Initialize SDK
$c6 = new C6Bank([
    'client_id' => $_ENV['C6_CLIENT_ID'],
    'client_secret' => $_ENV['C6_CLIENT_SECRET'],
    'certificate' => '/path/to/cert.pem',
    'private_key' => '/path/to/key.pem',
    'sandbox' => false,
    
    // Inject Dependencies
    'cache' => $cache,
    'logger' => $logger
]);
```

---

## 📚 Modules & Examples

Full documentation for each module can be found in **[EXAMPLES.md](./EXAMPLES.md)**.

| Module | Description | Resource Access |
| :--- | :--- | :--- |
| **Authentication** | OAuth2 Token Management | Internal |
| **Accounts** | Balance and Account Details | `$c6->accounts()` |
| **Bank Slips** | Issue, Consult, Cancel Boletos | `$c6->bankSlips()` |
| **PIX** | Dynamic QRCodes, Cob, CobV | `$c6->pix()` |
| **Webhooks** | PIX and Banking notifications | `$c6->pix()->webhook()`, `$c6->bankingWebhook()` |
| **Checkout** | E-commerce Payment Links | `$c6->checkout()` |
| **Schedule** | Payment Scheduling (DDA/Ted) | `$c6->schedule()` |
| **Statement** | Account Statements | `$c6->statement()` |
| **C6 Pay** | POS transactions and receivables | `$c6->c6pay()` |

---

## 🔒 Security

*   **mTLS Support**: The SDK handles mutual TLS authentication required by C6 Bank.
*   **Token Management**: OAuth2 tokens are potentially critical. Use a secure Cache backend (Redis/Memcached) in production.
*   **Sensitive Data**: The built-in Logger automatically redacts the `Authorization` header.

---

## 🤝 Contributing

We welcome contributions! Please check [CONTRIBUTING.md](./CONTRIBUTING.md) for details on code standards and testing.

1.  Fork the project.
2.  Create your feature branch (`git checkout -b feature/AmazingFeature`).
3.  Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4.  Push to the branch (`git push origin feature/AmazingFeature`).
5.  Open a Pull Request.

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

## 👨‍💻 Authors

Developed with ❤️ by **[Agência Taruga](https://www.agenciataruga.com)** and **Leandro Oliveira Nunes**.

- **Leandro Nunes** - *Lead Developer* - [GitHub](https://github.com/leandronunes07)
- **Agência Taruga** - [Website](https://www.agenciataruga.com)
