<?php

    namespace App\Repository;

    use App\Http\Requests\UsuarioRequest;
    use App\Models\Usuarios;
    use Illuminate\Http\JsonResponse;

    interface UsuarioRepository {
        
        public function salvar(UsuarioRequest $request): Usuarios;
        public function listar();
    }