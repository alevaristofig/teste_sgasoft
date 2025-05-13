<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use App\Service\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PedidoController extends Controller
{
    private $service;

    public function __construct(PedidoService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $result = $this->service->listar();

        return response()->json($result,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedidoRequest $request)
    {                
        $this->service->salvar($request);

        return response()->json(['msg' => 'Produto adicionado no carrinho'],200);
    }

    public function confirmarPedido(): JsonResponse {        
        $pedido = $this->service->confirmarPedido();

        return response()->json($pedido,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $result = $this->service->buscar($id);

        return response()->json($result,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedidoRequest $request, int $id): JsonResponse
    {
         $result = $this->service->atualizar($id, $request);

        return response()->json($result,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
