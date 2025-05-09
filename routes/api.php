<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UsuarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {

    Route::group([
        'as' => 'usuario'
    ], function() {
        Route::resource('usuarios',UsuarioController::class);
    });
});
