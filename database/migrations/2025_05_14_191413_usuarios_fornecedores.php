<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('usuarios_fornecedores', function (Blueprint $table) {
           $table->unsignedBigInteger('usuario_id');
           $table->unsignedBigInteger('fornecedor_id');

           $table->foreign('usuario_id')->references('id')->on('users');
           $table->foreign('fornecedor_id')->references('id')->on('fornecedores');

           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_fornecedores');
    }
};
