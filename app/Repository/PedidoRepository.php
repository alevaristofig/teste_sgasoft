<?php

    namespace App\Repository;

    use App\Http\Requests\PedidoRequest;
    use App\Models\Pedidos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface PedidoRepository {
        
        public function confirmarPedido(): Pedidos;
        public function salvar(PedidoRequest $request);
        public function listar(): Collection;
        public function buscar(int $id): Pedidos | null;
        public function atualizar(int $id, PedidoRequest $request): Pedidos | null;
        public function deletar(int $id): void;
        public function retirarItemCarrinho(int $id);
    }