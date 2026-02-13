# Contributing to C6 Bank PHP SDK

Thank you for considering contributing to this project! 🐢

## Requirements

- PHP >= 8.1
- Composer

## Environment Setup

1. Clone the repository:
```bash
git clone https://github.com/leandronunes07/c6bank-php-sdk.git
cd c6bank-php-sdk
```

2. Install dependencies:
```bash
composer install
```

## Running Tests

This project uses **PHPUnit** for unit testing. Make sure to write tests for new features.

```bash
./vendor/bin/phpunit
```

To run tests for a specific class:
```bash
./vendor/bin/phpunit tests/Unit/AccountDTOTest.php
```

## Code Standards

- Follow **PSR-12** for code style.
- Use `php-cs-fixer` to standardize code before sending a PR:
```bash
./vendor/bin/php-cs-fixer fix
```
- Use **DTOs** for new methods that receive or return complex data.
- Keep documentation updated.

## Pull Request Process

1. Create a branch for your feature (`feature/new-feature` or `fix/bug-fix`).
2. Implement and test your changes.
3. Ensure code style is compliant.
4. Submit a PR describing your changes in detail.

## Reporting Bugs

If you find a bug, please open an [Issue](https://github.com/leandronunes07/c6bank-php-sdk/issues) detailing:
- Steps to reproduce.
- Expected vs. actual behavior.
- PHP version and SDK version used.
