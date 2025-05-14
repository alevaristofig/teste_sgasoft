<?php

    namespace App\Service;

    use App\Repository\PedidoRepository;
    use App\Http\Requests\PedidoRequest;
    use App\Models\Pedidos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\Redis;

    class PedidoService implements PedidoRepository {

        private $model;

        public function __construct(Pedidos $model) {
            $this->model = $model;
        }

        public function listar(): Collection {
            try {
                return $this->model->all();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function listarCarrinho(): Array {
            try {
                return Redis::hgetall('carrinho:1');
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function salvar(PedidoRequest $request): void {
            try {                                                                                     
                $pedidos = Redis::hgetall('carrinho:1');

                $dados = $request->all();  

                if($pedidos === null) {                   
                    $dados['produtos'] = json_encode($dados['produtos']);                  
                } else {                   
                    $produtos = Redis::hget('carrinho:1','produtos');                                     
                    $dados['produtos'] = json_encode(array_merge(json_decode($produtos),$dados['produtos']));                   
                }  
                
                Redis::hmset('carrinho:1',$dados);
                
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }

        public function apagarCarrinho() {
            dd(Redis::del('carrinho:1'));
        }

        public function confirmarPedido(): Pedidos {            
            $pedido = Redis::hgetall('carrinho:1');

            return $this->model->create($pedido);
        }

        public function buscar(int $id): Pedidos | null {
            try {
                return $this->model->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function atualizar(int $id, PedidoRequest $request): Pedidos | null {
            try {
                $pedido = $this->model->find($id);

                 if($pedido !== null) {
                    $pedido->fornecedor_id = $request['fornecedor_id'];
                    $pedido->data = $request['data'];
                    $pedido->produtos = json_encode($request['produtos']);
                    $pedido->valor_total = $request['valor_total'];
                    $pedido->observacao = $request['observacao'];
                    $pedido->status = $request['status'];

                    $pedido->save();

                    return $pedido;
                 }                 

            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function deletar(int $id): void {
            try {
                $pedido = $this->model->find($id);

                $pedido->delete();
            } catch(\Exception $e) {
                dd($e);
            }
        }
    }