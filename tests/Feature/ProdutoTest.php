<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Models\Produtos;

class ProdutoTest extends TestCase
{
     public function test_InserirProdutoSucesso(): void {

        $dados = [
            "fornecedor_id" => 1,
            "referencia" => "Sony",
            "nome" => "Ps5",
            "cor" => "Branco",
            "preco" => "5000"
        ];

        $mock = Mockery::mock('alias:' . Produtos::class);
        $mock->shouldReceive('create')
            ->once()
            ->with($dados)
            ->andReturn((object) $dados);

        $result = Produtos::create($dados);

        $this->assertEquals('Sony',$result->referencia);
        $this->assertEquals(1,$result->fornecedor_id);
    }

    public function test_ListarProdutoSucesso(): void {

        $produto1 = new Produtos();
        $produto1->fornecedor_id = 1;
        $produto1->referencia = "Sony";
        $produto1->nome = "Ps5";
        $produto1->cor = "Branco";
        $produto1->preco = 5000;

        $produto2 = new Produtos();
        $produto2->fornecedor_id = 1;
        $produto2->referencia = "Nvidia";
        $produto2->nome = "RTX 5500";
        $produto2->cor = "Sem";
        $produto2->preco = "15342.98";

        $dados = [
            $produto1,
            $produto2
        ];

        $mock = Mockery::mock('alias:' . Produtos::class);
        $mock->shouldReceive('all')
            ->once()            
            ->andReturn($dados);

        $result = Produtos::all();

        $this->assertCount(2,$result);
        $this->assertEquals('RTX 5500',$result[1]->nome);
        $this->assertEquals(5000,$result[0]->preco);
    }

    public function test_BuscarProdutoSucesso(): void {

        $id = 1;
        $produto1 = new Produtos();
        $produto1->fornecedor_id = 1;
        $produto1->referencia = "Sony";
        $produto1->nome = "Ps5";
        $produto1->cor = "Branco";
        $produto1->preco = 5000;

        $mock = Mockery::mock('alias:' . Produtos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($produto1);

        $result = Produtos::find($id);

        $this->assertEquals('Branco',$result->cor);
        $this->assertEquals('Ps5',$result->nome);
    }

     public function test_AtualizarProdutoSucesso(): void {

        $id = 1;
        $produto1 = new Produtos();
        $produto1->fornecedor_id = 1;
        $produto1->referencia = "Sony";
        $produto1->nome = "Ps5";
        $produto1->cor = "Branco";
        $produto1->preco = 5000;

        $mock = Mockery::mock('alias:' . Produtos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($produto1);

        $produtoUpdate = Produtos::find($id);
        
        $produtoUpdate->referencia = "Sony SA";
        $produtoUpdate->nome = "Playstation 5";
        $produtoUpdate->cor = "Preto";
        $produtoUpdate->preco = "6563.12";

        $mock->shouldReceive('create')
            ->once()
            ->with($produtoUpdate)
            ->andReturn($produtoUpdate);

        $result = Produtos::create($produtoUpdate);

        $this->assertInstanceOf(Produtos::class,$result);
        $this->assertEquals('Playstation 5',$result->nome);        
    }

    public function test_DeletarProdutoSucesso(): void {

        $id = 1;
        $produto = new Produtos();

        $mock = Mockery::mock('alias:' . Produtos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($produto);

        $produto = Produtos::find($id);        

        $mock->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturnTrue();

        $result = Produtos::delete($id);
       
        $this->assertTrue($result);                
    }

}
