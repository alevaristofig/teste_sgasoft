<?php

    namespace App\Service;

    use App\Repository\UsuarioFornecedorRepository;
    use App\Http\Requests\UsuarioFornecedorRequest;
    use App\Models\UsuarioFornecedor;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class UsuarioFornecedorService implements UsuarioFornecedorRepository {

        private $usuarioFornecedor;

        public function __construct(UsuarioFornecedor $usuarioFornecedor) {
            $this->usuarioFornecedor = $usuarioFornecedor;
        }
        
        public function salvar(UsuarioFornecedorRequest $data): UsuarioFornecedor {
            try {                                                            
                return $this->usuarioFornecedor->create($data->all());
            } catch(\Exception $e) {
                dd($e);
            }
        }
    }