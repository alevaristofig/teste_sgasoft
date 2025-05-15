<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\FornecedorController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\UsuarioFornecedorController;
use App\Http\Controllers\Api\Auth\LoginJwtController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {

    Route::post('/login',[LoginJwtController::class,'login'])->name('login');
    Route::get('/logout',[LoginJwtController::class,'logout'])->name('logout');

    Route::group([
        'as' => 'usuario',
        'middleware'=> \Tymon\JWTAuth\Http\Middleware\Authenticate::class
    ], function() {
        Route::get('usuarios/vendedor',[UsuarioController::class,'buscarUsuarioVendedor']);
        Route::resource('usuarios',UsuarioController::class);
    });

    Route::group([
        'as' => 'usuariofornecedor'
    ], function() {
        Route::post('usuariofornecedor',[UsuarioFornecedorController::class,'salvar']);       
    });

    Route::group([
        'as' => 'fornecedor'
    ], function() {
        Route::resource('fornecedores',FornecedorController::class);
    });

    Route::group([
        'as' => 'produto'
    ], function() {
        Route::resource('produtos',ProdutoController::class);
        Route::post('/produtos/upload',[ProdutoController::class,'upload']);
    });

    Route::group([
        'as' => 'pedido'
    ], function() {
        Route::get('/pedidos/confirmarpedido',[PedidoController::class,'confirmarPedido']);
        Route::get('/pedidos/listarcarrinho',[PedidoController::class,'listarCarrinho']);
        Route::get('/pedidos/retiraritemcarrinho/{id}',[PedidoController::class,'retirarItemCarrinho']);
        Route::get('/pedidos/apagarCarrinho',[PedidoController::class,'apagarCarrinho']);
        Route::resource('pedidos',PedidoController::class);        
    });
});
