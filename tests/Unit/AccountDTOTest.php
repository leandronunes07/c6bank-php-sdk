<?php

namespace LeandroNunes\C6Bank\Tests\Unit;

use LeandroNunes\C6Bank\DTOs\AccountDTO;
use PHPUnit\Framework\TestCase;

class AccountDTOTest extends TestCase
{
    public function testCanCreateFromArray()
    {
        $data = [
            'id' => '123',
            'name' => 'John Doe',
            'balance' => 123.45,
            'currency' => 'BRL',
        ];

        $dto = AccountDTO::fromArray($data);

        $this->assertInstanceOf(AccountDTO::class, $dto);
        $this->assertEquals('123', $dto->id);
        $this->assertEquals('John Doe', $dto->name);
        $this->assertEquals(123.45, $dto->balance);
        $this->assertEquals('BRL', $dto->currency);
    }

    public function testCanConvertToArray()
    {
        $dto = new AccountDTO('456', 'Jane Doe', 1000.0, 'USD');

        $array = $dto->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('456', $array['id']);
        $this->assertEquals('Jane Doe', $array['name']);
        $this->assertEquals(1000.0, $array['balance']);
        $this->assertEquals('USD', $array['currency']);
    }
}
