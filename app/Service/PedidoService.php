<?php

    namespace App\Service;

    use App\Repository\PedidoRepository;
    use App\Http\Requests\PedidoRequest;
    use App\Models\Pedidos;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Database\Eloquent\Collection;

    class PedidoService implements PedidoRepository {

        private $model;

        public function __construct(Pedidos $model) {
            $this->model = $model;
        }
    }