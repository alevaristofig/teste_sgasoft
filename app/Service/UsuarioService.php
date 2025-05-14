<?php

    namespace App\Service;

    use App\Repository\UsuarioRepository;
    use App\Http\Requests\UsuarioRequest;
    use App\Models\User;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class UsuarioService implements UsuarioRepository {

        private $user;

        public function __construct(User $user) {
            $this->user = $user;
        }
        
        public function salvar(UsuarioRequest $request): User {
            try {
                 $data = $request->all();                 
                 $data['password'] = bcrypt($data['password']);     
                             
                return $this->user->create($data);
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function listar(): Collection {
            try {
                return $this->user->all();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function buscar(int $id): User {
            try {
                return $this->user->find($id);
            } catch(\Exception $e) {
                dd($e);
            }
        }

         public function atualizar(int $id, UsuarioRequest $request): User {
            try {
                $usuario = $this->user->find($id);

                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->password = $request->password;
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
                $usuario = $this->user->find($id);

                $usuario->delete();
            } catch(\Exception $e) {
                dd($e);
            }
        }

        public function buscarUsuarioVendedor(): Collection {
            return $this->user->where('tipo','V')->get();            
        }
    }