<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Models\Pedidos;

class PedidoTest extends TestCase
{
    public function test_InserirPedidoSucesso(): void {

        $dados = [
            "fornecedor_id" => 1,
            "data" => "2025-05-12 22:29:26",
            "produtos" => [
                'id' => 1,
                'valor' => 56.4,
                'quantidade' => 3
            ],
            "valor_total" => 169.2,
            "observacao" => "Teste",
            "status" => "Pendente"
        ];

        $mock = Mockery::mock('alias:' . Pedidos::class);
        $mock->shouldReceive('create')
            ->once()
            ->with($dados)
            ->andReturn((object) $dados);

        $result = Pedidos::create($dados);

        $this->assertEquals(169.2,$result->valor_total);
        $this->assertEquals(1,$result->fornecedor_id);
    }

    public function test_BuscarPedidoSucesso(): void {

        $id = 1;
        $pedido = new Pedidos();
        $pedido->fornecedor_id = 1;
        $pedido->data = "2025-05-12 22:29:26";
        $pedido->produtos = [
                'id' => 1,
                'valor' => 56.4,
                'quantidade' => 3
        ];
        $pedido->valor_total = 169.2;
        $pedido->observacao = "Observacao";
        $pedido->status = "Pendente";

        $mock = Mockery::mock('alias:' . Pedidos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($pedido);

        $result = Pedidos::find($id);

        $this->assertEquals('2025-05-12 22:29:26',$result->data);
        $this->assertEquals('Pendente',$result->status);
    }

    public function test_AtualizarPedidoSucesso(): void {

        $id = 1;
        $pedido = new Pedidos();
        $pedido->fornecedor_id = 1;
        $pedido->data = "2025-05-12 22:29:26";
        $pedido->produtos = [
                'id' => 1,
                'valor' => 56.4,
                'quantidade' => 3
        ];
        $pedido->valor_total = 169.2;
        $pedido->observacao = "Observacao";
        $pedido->status = "Pendente";

        $mock = Mockery::mock('alias:' . Pedidos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($pedido);

        $pedidosUpdate = Pedidos::find($id);
        
        $pedidosUpdate->quantidade = 2;
        $pedidosUpdate->valor_total = 130.8;
        $pedidosUpdate->status = "Cancelado,";

        $mock->shouldReceive('create')
            ->once()
            ->with($pedidosUpdate)
            ->andReturn($pedidosUpdate);

        $result = Pedidos::create($pedidosUpdate);

        $this->assertInstanceOf(Pedidos::class,$result);
        $this->assertEquals(130.8,$result->valor_total);        
    }

    public function test_DeletarPedidoSucesso(): void {

        $id = 1;
        $pedido = new Pedidos();

        $mock = Mockery::mock('alias:' . Pedidos::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($pedido);

        $produto = Pedidos::find($id);        

        $mock->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturnTrue();

        $result = Pedidos::delete($id);
       
        $this->assertTrue($result);                
    }
}
