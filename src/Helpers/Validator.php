<?php

namespace LeandroNunes\C6Bank\Helpers;

use InvalidArgumentException;

class Validator
{
    public static function validateCpf(string $cpf): void
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new InvalidArgumentException("Invalid CPF length: $cpf");
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidArgumentException("Invalid CPF format: $cpf");
        }

        // Validate digits
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new InvalidArgumentException("Invalid CPF: $cpf");
            }
        }
    }

    public static function validateCnpj(string $cnpj): void
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            throw new InvalidArgumentException("Invalid CNPJ length: $cnpj");
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            throw new InvalidArgumentException("Invalid CNPJ format: $cnpj");
        }

        // Validate digits
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i])
        ;
        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            throw new InvalidArgumentException("Invalid CNPJ: $cnpj");
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++])
        ;
        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            throw new InvalidArgumentException("Invalid CNPJ: $cnpj");
        }
    }

    public static function validateTxId(string $txid): void
    {
        if (!preg_match('/^[a-zA-Z0-9]{26,35}$/', $txid)) {
            throw new InvalidArgumentException("Invalid TxId: $txid. Must be alphanumeric and between 26 and 35 characters.");
        }
    }

    public static function validateUuid(string $uuid): void
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid)) {
            throw new InvalidArgumentException("Invalid UUID: $uuid");
        }
    }
}
