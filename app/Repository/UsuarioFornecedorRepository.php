<?php

    namespace App\Repository;

    use App\Http\Requests\UsuarioFornecedorRequest;
    use App\Models\UsuarioFornecedor;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface UsuarioFornecedorRepository {
        
        public function salvar(UsuarioFornecedorRequest $request): UsuarioFornecedor;
    }