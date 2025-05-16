<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FornecedorRequest;
use App\Service\FornecedorService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FornecedorController extends Controller
{
    private $service;

    public function __construct(FornecedorService $service) {
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
    public function store(FornecedorRequest $request): JsonResponse
    {
        $result = $this->service->salvar($request);

        if($result === false) {
            return response()->json(['msg' => 'Ocorreu um erro e a operação não pode ser realizada'],500);
        }

        return response()->json($result,201);
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
    public function update(FornecedorRequest $request, int $id): JsonResponse
    {
        $result = $this->service->atualizar($id, $request);

        return response()->json($result,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->deletar($id);

        return response()->json(['msg' => "Fornecedor deletado com sucesso!"],204);
    }
}
