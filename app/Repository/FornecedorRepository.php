<?php

    namespace App\Repository;

    use App\Http\Requests\FornecedorRequest;
    use App\Models\Fornecedor;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    interface FornecedorRepository {
        
        public function salvar(FornecedorRequest $request): Fornecedor | bool;
        public function listar(): Collection;
        public function buscar(int $id): Fornecedor | null;
        public function atualizar(int $id, FornecedorRequest $request): Fornecedor;
        public function deletar(int $id): void;
    }