<?php

    namespace App\Service;

    use App\Repository\FornecedorRepository;
    use App\Http\Requests\FornecedorRequest;
    use App\Models\Fornecedor;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class FornecedorService implements FornecedorRepository {

        private $model;

        public function __construct(Fornecedor $model) {
            $this->model = $model;
        }
        
        public function salvar(FornecedorRequest $request): Fornecedor {
            try {                                
                if($this->validarCnpj($request->cnpj)) {
                    return $this->model->create($request->all());
                } else {
                    throw new \Exception("Cnpj Inválido");
                }                
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

        public function buscar(int $id): Fornecedor {
            try {
                return $this->model->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function atualizar(int $id, FornecedorRequest $request): Fornecedor {
            try {
                $fornecedor = $this->model->find($id);

                 if($this->validarCnpj($request->cnpj)) {
                    $fornecedor->nome = $request->nome;
                    $fornecedor->cnpj = $request->cnpj;
                    $fornecedor->cep = $request->cep;
                    $fornecedor->endereco = $request->endereco;
                    $fornecedor->status = $request->status;

                    $fornecedor->save();

                    return $fornecedor;                    
                } else {
                    throw new \Exception("Cnpj Inválido");
                }                  

            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function deletar(int $id): void {
            try {
                $fornecedor = $this->model->find($id);

                $fornecedor->delete();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        private function validarCnpj(string $cnpj): bool {
            $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	
            if (strlen($cnpj) != 14) {
                return false;
            }
                
            if (preg_match('/(\d)\1{13}/', $cnpj)) {
                return false;	
            }

            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
            {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

	        $resto = $soma % 11;

            if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
                return false;
            }

            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
            {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

	        $resto = $soma % 11;

	        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
        }
    }