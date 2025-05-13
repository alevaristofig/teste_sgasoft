<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\FornecedorController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\PedidoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {

    Route::group([
        'as' => 'usuario'
    ], function() {
        Route::resource('usuarios',UsuarioController::class);
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
        Route::resource('pedidos',PedidoController::class);        
    });
});
