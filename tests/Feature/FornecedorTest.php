<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;
use App\Models\Fornecedor;

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

    public function test_ListarFornecedorSucesso(): void {

        $fornecedor1 = new Fornecedor();
        $fornecedor1->nome = "Alexandre";
        $fornecedor1->cnpj = "61.018.515/0001-03";
        $fornecedor1->cep = "12345";
        $fornecedor1->endereco = "Rua teste";
        $fornecedor1->status = 1;

        $fornecedor2 = new Fornecedor();
        $fornecedor2->nome = "Adriane";
        $fornecedor2->cnpj = "61.018.515/0001-03";
        $fornecedor2->cep = "12345";
        $fornecedor2->endereco = "Rua teste";
        $fornecedor2->status = 0;

        $dados = [
            $fornecedor1,
            $fornecedor2
        ];

        $mock = Mockery::mock('alias:' . Fornecedor::class);
        $mock->shouldReceive('all')
            ->once()            
            ->andReturn($dados);

        $result = Fornecedor::all();

        $this->assertCount(2,$result);
        $this->assertEquals('61.018.515/0001-03',$result[0]->cnpj);
        $this->assertEquals('Adriane',$result[1]->nome);
    }

}
