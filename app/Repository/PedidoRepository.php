<?php

    namespace App\Repository;

    use App\Http\Requests\PedidoRequest;
    use App\Models\Pedidos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface PedidoRepository {
        
        public function salvar(PedidoRequest $request): Pedidos;
        public function listar(): Collection;
        public function buscar(int $id): Pedidos;
        public function atualizar(int $id, PedidoRequest $request): Pedidos;
        public function deletar(int $id): void;
    }