<?php

    namespace App\Service;

    use App\Repository\UsuarioRepository;
    use App\Http\Requests\UsuarioRequest;
    use App\Models\Usuarios;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class UsuarioService implements UsuarioRepository {

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
    }