<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\UsuarioFornecedorService;
use App\Http\Requests\UsuarioFornecedorRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioFornecedorController extends Controller
{
    private $service;

    public function __construct(UsuarioFornecedorService $service) {
        $this->service = $service;
    }

    public function salvar(UsuarioFornecedorRequest $request): JsonResponse {
        $result = $this->service->salvar($request);

        return response()->json($result,200);
     }
}
