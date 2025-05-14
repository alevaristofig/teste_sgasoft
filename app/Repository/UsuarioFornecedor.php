<?php

    namespace App\Repository;

    use App\Http\Requests\UsuarioRequest;
    use App\Models\UsuarioFornecedorRequest;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface UsuarioFornecedorRepository {
        
        public function salvar(UsuarioFornecedorRequest $request): UsuarioFornecedor;
    }