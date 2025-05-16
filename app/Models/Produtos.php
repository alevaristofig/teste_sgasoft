<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produtos extends Model
{
    protected $fillable = [
        'fornecedor_id', 'referencia', 'nome', 'cor', 'preco'
    ];

    public function fornecedor(): BelongsTo {
        return $this->belongsTo(Fornecedor::class);
    }
}
