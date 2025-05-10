<?php

    namespace App\Service;

    use App\Repository\FornecedorRepository;
    use App\Http\Requests\FornecedorRequest;
    use App\Models\Fornecedor;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class FornecedorService implements FornecedorRepository {

        private $usuario;

        public function __construct(Usuarios $usuarios) {
            $this->usuario = $usuarios;
        }
        
        public function salvar(UsuarioRequest $request): Usuarios {
            try {
                return $this->usuario->create($request->all());
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function listar(): Collection {
            try {
                return $this->usuario->all();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function buscar(int $id): Usuarios {
            try {
                return $this->usuario->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

         public function atualizar(int $id, UsuarioRequest $request): Usuarios {
            try {
                $usuario = $this->usuario->find($id);

                $usuario->nome = $request->nome;
                $usuario->email = $request->email;
                $usuario->senha = $request->senha;
                $usuario->status = $request->status;
                $usuario->tipo = $request->tipo;

                $usuario->save();

                return $usuario;

            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function deletar(int $id): void {
            try {
                $usuario = $this->usuario->find($id);

                $usuario->delete();
            } catch(\Exception $e) {
                dd($e);
            }
        }
    }