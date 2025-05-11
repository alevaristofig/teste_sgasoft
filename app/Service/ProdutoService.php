<?php

    namespace App\Service;

    use App\Repository\ProdutoRepository;
    use App\Http\Requests\ProdutoRequest;
    use App\Models\Produtos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class ProdutoService implements ProdutoRepository {

        private $model;

        public function __construct(Produtos $model) {
            $this->model = $model;
        }
        
        public function salvar(ProdutoRequest $request): Produtos {
            try {                                
                return $this->model->create($request->all());             
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }

        public function listar(): Collection {
            try {
                return $this->model->all();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function buscar(int $id): Produtos {
            try {
                return $this->model->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function atualizar(int $id, ProdutoRequest $request): Produtos {
            try {
                
                $produto = $this->model->find($id);

                $produto->referencia = $request->referencia;
                $produto->nome = $request->nome;
                $produto->cor = $request->cor;
                $produto->preco = $request->preco;

                $produto->save();

                return $produto;
                            
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function deletar(int $id): void {
            try {
                $produto = $this->model->find($id);

                $produto->delete();
            } catch(\Exception $e) {
                dd($e);
            }
        }
    }