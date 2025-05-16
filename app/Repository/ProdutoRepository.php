<?php

    namespace App\Repository;

    use App\Http\Requests\ProdutoRequest;
    use App\Models\Produtos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;

    interface ProdutoRepository {
        
        public function salvar(ProdutoRequest $request): Produtos;
        public function listar(): Collection;
        public function buscar(int $id): Produtos;
        public function atualizar(int $id, ProdutoRequest $request): Produtos;
        public function deletar(int $id): void;
    }