<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Models\Usuarios;

class UsuarioTest extends TestCase
{
    public function test_InserirUsuarioSucess(): void {

        $dados = [
            "nome" => "Alexandre",
            "email" => "alevaristofig@gmail.com",
            "senha" => "12345",
            "status" => "1",
            "tipo" => "V"
        ];

        $mock = Mockery::mock('alias:' . Usuarios::class);
        $mock->shouldReceive('create')
            ->once()
            ->with($dados)
            ->andReturn((object) $dados);

        $result = Usuarios::create($dados);

        $this->assertEquals('Alexandre',$result->nome);
        $this->assertEquals('alevaristofig@gmail.com',$result->email);
    }
}
