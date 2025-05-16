<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fornecedor extends Model
{
    protected $table = "fornecedores";
    
    protected $fillable = [
        'nome', 'cnpj', 'cep', 'endereco', 'status'
    ];

    public function produtos(): HasMany {
        return $this->hasMany(Produto::class);
    }

    public function pedidos(): HasMany {
        return $this->hasMany(Pedidos::class);
    }

    public function fornecedorUsuario(): HasMany
    {
        return $this->hasMany(UsuarioFornecedor::class);
    }
}