<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UsuarioResource;
use App\Models\Usuario;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return UsuarioResource::collection(Usuario::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:50|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'senha' => 'required|min:6',
            'celular' => 'nullable',
            'tipo_usuario_id' => 'required|exists:tipo_usuarios,id',
            'midia_social' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Invalidos', 422, $validator->errors());
        }

        $data = $validator->validated();

        $usuario = Usuario::create([
            'nome' => $data['nome'],
            'apelido' => $data['apelido'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
            'celular' => $data['celular'],
            'tipo_usuario_id' => $data['tipo_usuario_id'],
            'midia_social' => $data['midia_social'],
        ]);

        return $usuario ? $this->response('Usuario Cadastrado', 201, new UsuarioResource($usuario))
            : $this->error('Usuario nao cadastrado', 400);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UsuarioResource(usuario::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'apelido' => ['required', 'string', 'max:50', Rule::unique('usuarios')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($id)],
            'senha' => 'required|min:6',
            'celular' => 'nullable',
            'tipo_usuario_id' => 'required|exists:tipo_usuarios,id',
            'midia_social' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Invalidos', 422, $validator->errors());
        }

        $data = $validator->validated();

        $updateUsuario = Usuario::find($id);

        $usuario = $updateUsuario->update([
            'nome' => $data['nome'],
            'apelido' => $data['apelido'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
            'celular' => $data['celular'],
            'tipo_usuario_id' => $data['tipo_usuario_id'],
            'midia_social' => $data['midia_social'],
        ]);

        return $usuario ? $this->response('Usuario Atualizado', 201, new UsuarioResource($updateUsuario))
            : $this->error('Usuario nao Atualizado', 400);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $deleted = $usuario->delete();

        return $deleted ? $this->response('Usuario deletado com sucesso', 200) :
            $this->response('Falha ao deletar Usuario', 400);
    }
}
