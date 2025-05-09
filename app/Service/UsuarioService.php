<?php

    namespace App\Service;

    use App\Repository\UsuarioRepository;
    use App\Http\Requests\UsuarioRequest;
    use App\Models\Usuarios;
    use Illuminate\Http\JsonResponse;

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
    }