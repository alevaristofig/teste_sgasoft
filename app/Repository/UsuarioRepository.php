<?php

    namespace App\Repository;

    use App\Http\Requests\UsuarioRequest;
    use App\Models\User;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface UsuarioRepository {
        
        public function salvar(UsuarioRequest $request): User;
        public function listar(): Collection;
        public function buscar(int $id): User;
        public function atualizar(int $id, UsuarioRequest $request): User;
        public function deletar(int $id): void;
    }