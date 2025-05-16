<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioFornecedor extends Model
{
    protected $table = "usuarios_fornecedores";

    protected $fillable = [
        'usuario_id', 'fornecedor_id',
    ];

    public function usuario(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function fornecedor(): BelongsToMany
    {
        return $this->belongsToMany(Fornecedor::class);
    }
}
