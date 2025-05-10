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

    public function test_ListarUsuarioSucess(): void {

        $usuario1 = new Usuarios();
        $usuario1 ->nome = "Alexandre";
        $usuario1 ->email = "alevaristofig@gmail.com";
        $usuario1 ->senha = "12345";
        $usuario1 ->status = "1";
        $usuario1 ->tipo = "V";

        $usuario2 = new Usuarios();
        $usuario2 ->nome = "Adriane";
        $usuario2 ->email = "adriane@gmail.com";
        $usuario2 ->senha = "12345";
        $usuario2 ->status = "1";
        $usuario2 ->tipo = "V";

        $dados = [
            $usuario1,
            $usuario2
        ];

        $mock = Mockery::mock('alias:' . Usuarios::class);
        $mock->shouldReceive('all')
            ->once()            
            ->andReturn($dados);

        $result = Usuarios::all();

        $this->assertCount(2,$result);
        $this->assertEquals('alevaristofig@gmail.com',$result[0]->email);
        $this->assertEquals('Adriane',$result[1]->nome);
    }

     public function test_BuscarUsuarioSucess(): void {

        $id = 1;
        $usuario = new Usuarios();
        $usuario ->nome = "Alexandre";
        $usuario ->email = "alevaristofig@gmail.com";
        $usuario ->senha = "12345";
        $usuario ->status = "1";
        $usuario ->tipo = "V";

        $mock = Mockery::mock('alias:' . Usuarios::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($usuario);

        $result = Usuarios::find($id);

        $this->assertEquals('alevaristofig@gmail.com',$result->email);
         $this->assertEquals('12345',$result->senha);
    }

    public function test_AtualizarUsuarioSucess(): void {

        $id = 1;
        $usuario = new Usuarios();
        $usuario ->nome = "Alexandre";
        $usuario ->email = "alevaristofig@gmail.com";
        $usuario ->senha = "12345";
        $usuario ->status = "1";
        $usuario ->tipo = "A";

        $mock = Mockery::mock('alias:' . Usuarios::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($usuario);

        $usuarioUpdate = Usuarios::find($id);

        $usuarioUpdate ->nome = "Alexandre Evaristo de Figueiredo";
        $usuarioUpdate ->email = "alevaristofig@gmail.com.br";
        $usuarioUpdate ->senha = "1234567";
        $usuarioUpdate ->status = "1";
        $usuarioUpdate ->tipo = "A";

        $mock->shouldReceive('create')
            ->once()
            ->with($usuarioUpdate)
            ->andReturn($usuarioUpdate);

        $result = Usuarios::create($usuarioUpdate);

        $this->assertInstanceOf(Usuarios::class,$result);
        $this->assertEquals('Alexandre Evaristo de Figueiredo',$result->nome);        
    }

     public function test_DeletarUsuarioSucess(): void {

        $id = 1;
        $usuario = new Usuarios();
        /*$usuario ->nome = "Alexandre";
        $usuario ->email = "alevaristofig@gmail.com";
        $usuario ->senha = "12345";
        $usuario ->status = "1";
        $usuario ->tipo = "A";*/

        $mock = Mockery::mock('alias:' . Usuarios::class);
        $mock->shouldReceive('find')
            ->once()    
            ->with($id)        
            ->andReturn($usuario);

        $usuario = Usuarios::find($id);        

        $mock->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturnTrue();

        $result = Usuarios::delete($id);
       
        $this->assertTrue($result);                
    }
}
