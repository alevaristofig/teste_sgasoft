<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request): JsonResponse {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string'
        ])->validate();

        if(!$token = auth('api')->attempt($credentials))
        {            
            return response()->json(['error' => "Acesso Negado"], 401); 
        }       

        return response()->json([
            'token' =>$token,
            'tipo' => auth('api')->user()->tipo
        ],200);
    }

    public function logout(): void
    {
        auth('api')->logout();
    }
}
