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

        public function listar(): Array {
            try {
                return Redis::hgetall('carrinho:1');
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function salvar(PedidoRequest $request): void {
            try {                                
                                     
                $pedidos = Redis::get('pedidos');

                if($pedidos === null) {
                    $dados = $request->all();
                    $dados['produtos'] = json_encode($dados['produtos']);

                    Redis::hmset('carrinho:1',$dados);
                }
                
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }
    }