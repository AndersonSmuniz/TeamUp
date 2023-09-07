<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);


        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && password_verify($request->senha, $usuario->senha)) {
            $token = $usuario->createToken('auth-token')->plainTextToken;

            return response()->json(['access_token' => $token], 200);
        }

        return response()->json(['message' => 'Credenciais invalidas'], 401);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout bem-sucedido'], 200);
    }
}
