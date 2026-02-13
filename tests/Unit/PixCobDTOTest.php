<?php

namespace LeandroNunes\C6Bank\Tests\Unit;

use LeandroNunes\C6Bank\DTOs\Pix\CalendarioDTO;
use LeandroNunes\C6Bank\DTOs\Pix\CobDTO;
use LeandroNunes\C6Bank\DTOs\Pix\DevedorDTO;
use LeandroNunes\C6Bank\DTOs\Pix\ValorDTO;
use PHPUnit\Framework\TestCase;

class PixCobDTOTest extends TestCase
{
    public function testCanCreateCobStructure()
    {
        $calendario = new CalendarioDTO(expiracao: 3600);
        $valor = new ValorDTO(original: '123.45');
        $devedor = new DevedorDTO(nome: 'João', cpf: '12345678900');

        $cob = new CobDTO(
            calendario: $calendario,
            valor: $valor,
            chave: 'KEY-123',
            devedor: $devedor,
            solicitacaoPagador: 'Teste'
        );

        $this->assertEquals('123.45', $cob->valor->original);
        $this->assertEquals(3600, $cob->calendario->expiracao);
        $this->assertEquals('12345678900', $cob->devedor->cpf);
    }

    public function testSerialization()
    {
        $data = [
            'calendario' => ['expiracao' => 3600],
            'valor' => ['original' => '50.00'],
            'chave' => 'KEY-TEST',
            'solicitacaoPagador' => 'Pay me',
            'devedor' => [
                'nome' => 'Jane',
                'cpf' => '111.222.333-44',
            ],
        ];

        $cob = CobDTO::fromArray($data);

        $this->assertEquals('50.00', $cob->valor->original);
        $this->assertEquals('11122233344', $cob->devedor->cpf); // Check sanitization
        $this->assertEquals('KEY-TEST', $cob->chave);
    }
}
