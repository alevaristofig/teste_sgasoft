<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Service\UsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UsuarioController extends Controller
{
    private $service;

    public function __construct(UsuarioService $service) {
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
    public function store(UsuarioRequest $request): JsonResponse
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
    public function update(UsuarioRequest $request, int $id): JsonResponse
    {        
        $result = $this->service->atualizar($id, $request);

        return response()->json($result,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
       $this->service->deletar($id);

       return response()->json(['msg' => "Usuario deletado com sucesso!"],204);
    }

     public function buscarUsuarioVendedor() {
        $result = $this->service->buscarUsuarioVendedor();

        return response()->json($result,200);
     }
}
