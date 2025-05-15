<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedidos extends Model
{
    protected $fillable = [
        'fornecedor_id', 'data', 'produtos', 'valor_total', 'observacao', 'status'
    ];

    public function fornecedor(): BelongsTo {       
       return $this->belongsto(Fornecedor::class);
    }
}
