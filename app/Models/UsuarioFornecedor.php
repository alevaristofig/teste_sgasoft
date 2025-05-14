<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioFornecedor extends Model
{
    protected $table = "usuarios_fornecedores";

    protected $fillable = [
        'usuario_id', 'fornecedor_id',
    ];
}
