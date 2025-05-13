<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $fillable = [
        'fornecedor_id', 'data', 'produtos', 'valor_total', 'observacao', 'status'
    ];
}
