<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function store(StoreUsuarioRequest $request)
    {
        $usuario = new Usuario();
        $usuario->nome = $request->input('nome');
        $usuario->apelido = $request->input('apelido');
        $usuario->email = $request->input('email');
        $usuario->senha = Hash::make($request->input('senha'));

        $usuario->celular = $request->has('celular') ? $request->input('celular') : null;
        $usuario->redesocial = $request->has('redesocial') ? $request->input('redesocial') : null;

        $usuario->save();

        return response()->json(['message' => 'Usuário criado com sucesso'], 201);
    }

    public function index()
    {
        $usuarios = Usuario::all();

        return response()->json($usuarios);
    }

    public function show($id)
    {
        return Usuario::findOrFail($id);
    }

    public function destroy($id)
    {
        return true;
    }

}
