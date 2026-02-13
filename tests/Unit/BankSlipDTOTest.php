<?php

namespace LeandroNunes\C6Bank\Tests\Unit;

use LeandroNunes\C6Bank\DTOs\BankSlip\AddressDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\BankSlipDTO;
use LeandroNunes\C6Bank\DTOs\BankSlip\PayerDTO;
use PHPUnit\Framework\TestCase;

class BankSlipDTOTest extends TestCase
{
    public function testCanCreateFullStructure()
    {
        $address = new AddressDTO(
            'Av. Paulista',
            '1000',
            'Bela Vista',
            'São Paulo',
            'SP',
            '01310-100',
            'CJ 10'
        );

        $payer = new PayerDTO(
            'John Doe',
            '123.456.789-00',
            $address
        );

        $boleto = new BankSlipDTO(
            150.00,
            '2024-12-31',
            $payer,
            'REF-001'
        );

        $this->assertEquals(150.00, $boleto->amount);
        $this->assertEquals('REF-001', $boleto->yourNumber);
        $this->assertEquals('John Doe', $boleto->payer->name);
        $this->assertEquals('Av. Paulista', $boleto->payer->address->street);
    }

    public function testSerialization()
    {
        $data = [
            'amount' => 100.0,
            'dueDate' => '2024-01-01',
            'payer' => [
                'name' => 'Jane Doe',
                'document' => '98765432100',
                'address' => [
                    'street' => 'Rua A',
                    'number' => '10',
                    'neighborhood' => 'Bairro B',
                    'city' => 'Cidade C',
                    'state' => 'UF',
                    'zipCode' => '12345000',
                ],
            ],
        ];

        $boleto = BankSlipDTO::fromArray($data);

        $this->assertInstanceOf(BankSlipDTO::class, $boleto);
        $this->assertEquals(100.0, $boleto->amount);
        $this->assertEquals('Jane Doe', $boleto->payer->name);
        $this->assertEquals('Rua A', $boleto->payer->address->street);
        $this->assertEquals('12345000', $boleto->payer->address->zipCode);
    }
}
