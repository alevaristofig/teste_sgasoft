<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class FornecedorTest extends TestCase
{
   public function test_InserirFornecedorSucesso(): void {

        $dados = [
            "nome" => "Alexandre",
            "cnpj" => "1223412121",
            "cep" => "31015090",
            "endereco" => "Rua Anhanguera 109, Santa Tereza",
            "status" => 1
        ];

        $mock = Mockery::mock('alias:' . Fornecedor::class);
        $mock->shouldReceive('create')
            ->once()
            ->with($dados)
            ->andReturn((object) $dados);

        $result = Fornecedor::create($dados);

        $this->assertEquals('Alexandre',$result->nome);
        $this->assertEquals('1223412121',$result->cnpj);
    }

}
