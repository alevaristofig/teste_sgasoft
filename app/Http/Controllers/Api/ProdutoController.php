<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Service\ProdutoService;
use App\Jobs\ProdutoCsvJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    private $service;

    public function __construct(ProdutoService $service) {
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
    public function store(ProdutoRequest $request): JsonResponse
    {
        $result = $this->service->salvar($request);

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
    public function update(ProdutoRequest $request, int $id): JsonResponse
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

        return response()->json(['msg' => "Produto deletado com sucesso!"],204);
    }

    public function upload(Request $request) {                

        $timestamp = now()->format('Y-m-d-H-i-s');
        $nomeArquivo = "produto_{$timestamp}.csv";        

        $path = $request->file('produtos')->storeAs('uploads',$nomeArquivo);

        ProdutoCsvJob::dispatch($path);

        return response()->json(['msg' => "Os Produtos estão sendo importados!"],200);
    }
}
