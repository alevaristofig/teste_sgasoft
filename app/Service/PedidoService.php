<?php

    namespace App\Service;

    use App\Repository\PedidoRepository;
    use App\Http\Requests\PedidoRequest;
    use Illuminate\Http\Request;
    use App\Models\Pedidos;
    use App\Models\Produtos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\Redis;

    class PedidoService implements PedidoRepository {

        private $model;
        private $produto;

        public function __construct(Pedidos $model, Produtos $produto) {
            $this->model = $model;
            $this->produto = $produto;
        }

        public function listar(): Collection {
            try {
               return $this->model->with('fornecedor:id,id,nome')->get();                
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function listarCarrinho()/*: Array*/ {
            try {
                $carrinho = Redis::hgetall('carrinho:1');                                
                $produtos = json_decode($carrinho['produtos']);                 
               
                $produtosCarrinho = $this->tranformarObjetoEmArray($produtos);
                
                $valorTotal = 0;
                $quantidadeTotal = 0;
                $result = [];

                foreach($produtosCarrinho AS $key => $produto) { 

                    $nome = $this->produto->select('nome')->where('id',$produto['id'])->get();
                    $novoElemento = [
                        'id' => $produto['id'],
                        'nome' => $nome[0]->nome,
                        'valor' =>  $produto['valor'],
                        'quantidade' =>  $produto['quantidade']
                    ];

                    $valorTotal+= $produto['valor'];
                    $quantidadeTotal+= $produto['quantidade'];                   
                    $result[] = $novoElemento;                       
                }

                $result['total'] = $valorTotal;
                $result['quantidadeTotal'] = $quantidadeTotal;

                return $result;
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function salvar(PedidoRequest $request)/*: bool*/ {
            try {                                                                                     
                $pedidos = Redis::hgetall('carrinho:1');

                $dados = $request->all();  

                if(count($pedidos) === 0) {                                                     
                    $dados['produtos'] = json_encode($dados['produtos']);                 
                } else {                                                         
                    $produtos = Redis::hget('carrinho:1','produtos');                   
                    $produtosCarrinho =  json_decode($produtos,true);  
                    $produtosCarrinho[] = $dados['produtos'];

                    $dados['produtos'] = json_encode($produtosCarrinho);   
                }  
                
                return Redis::hmset('carrinho:1',$dados);
                
            } catch(\Exception $e) {
                return $e->getMessage();
            }
        }

        public function apagarCarrinho() {
            Redis::del('carrinho:1');
        }

        public function confirmarPedido(): Pedidos {            
            $pedido = Redis::hgetall('carrinho:1');

            Redis::del('carrinho:1');

            return $this->model->create($pedido);
        }

        public function buscar(int $id): Pedidos | null {
            try {
                return $this->model->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function retirarItemCarrinho(int $id) {
            $produtos = Redis::hget('carrinho:1','produtos');                                      
            $produtosCarrinho =  json_decode($produtos,true); 
            $produtosCarrinho = $this->tranformarObjetoEmArray($produtosCarrinho); 

            $novoElemento = array_filter($produtosCarrinho,function($i) use ($id) {
                $indice = key($i);
                return $i[$indice] != $id;
            });

            Redis::hmset('carrinho:1','produtos',json_encode($novoElemento));
        }

        public function atualizar(int $id, Request $request): Pedidos | null {
            try {
                $pedido = $this->model->find($id);

                 if($pedido !== null) {                   
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

        private function tranformarObjetoEmArray($produtos) {
            $indices = ['id','valor','quantidade','nome'];

            if(isset($produtos->id)) {
                $produtosCarrinho[] = array(
                    'id' => isset($produtos->id) ? $produtos->id : $produtos['id'],
                    'nome' => isset($produtos->nome) ? $produtos->nome : $produtos['nome'],
                    'valor' => isset($produtos->valor) ? $produtos->valor : $produtos['valor'],
                    'quantidade' => isset($produtos->quantidade) ? $produtos->quantidade : $produtos['quantidade'],
                );
            }
                            
            foreach($produtos AS $key => $prod) {                
                if(!in_array($key,$indices)) {                                      
                    $produtosCarrinho[] = array(
                        'id' => isset($prod->id) ? $prod->id : $prod['id'],
                        'valor' => isset($prod->valor) ? $prod->valor : $prod['valor'],
                        'quantidade' => isset($prod->quantidade) ? $prod->quantidade : $prod['quantidade'],
                    );
                }                                      
            }

            return $produtosCarrinho;
        }
    }