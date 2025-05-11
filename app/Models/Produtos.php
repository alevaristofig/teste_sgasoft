<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $fillable = [
        'fornecedor_id', 'referencia', 'nome', 'cor', 'preco'
    ];
}
