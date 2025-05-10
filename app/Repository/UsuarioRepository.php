<?php

    namespace App\Repository;

    use App\Http\Requests\UsuarioRequest;
    use App\Models\Usuarios;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface UsuarioRepository {
        
        public function salvar(UsuarioRequest $request): Usuarios;
        public function listar(): Collection;
        public function buscar(int $id): Usuarios;
    }