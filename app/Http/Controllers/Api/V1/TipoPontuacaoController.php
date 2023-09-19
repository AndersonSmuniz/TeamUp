<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TipoPontuacaoResource;
use App\Http\Resources\V1\UsuarioResource;
use App\Models\Esporte;
use App\Models\TipoPontuacao;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoPontuacaoController extends Controller
{
    use HttpResponses;

    public function index($esporte_id)
    {
        try {
            $esporte = Esporte::findOrFail($esporte_id);

            return TipoPontuacaoResource::collection(TipoPontuacao::where('esporte_id', $esporte->id)->get());

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }

    }

    public function store(Request $request, Esporte $esporte)
    {
        if ($esporte) {
            $validator = Validator::make($request->all(), [
                'posicao' => 'required|string|max:50',
                'pontuacao_placar' => 'required|boolean',
                'nome_pontuacao' => 'required|string|max:50',
                'valor_pontuacao' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados Invalidos', 422, $validator->errors());
            }

            $data = $validator->validated();

            $tipo_pontuacao = TipoPontuacao::create([
                'posicao' => $data['posicao'],
                'pontuacao_placar' => $data['pontuacao_placar'],
                'valor_pontuacao' => $data['valor_pontuacao'],
                'nome_pontuacao' => $data['nome_pontuacao'],
                'esporte_id' => $esporte->id,
            ]);

            return $tipo_pontuacao ? $this->response('Tipo_pontuacao Cadastrado', 201, new TipoPontuacaoResource($tipo_pontuacao))
                : $this->error('Tipo_pontuacao nao cadastrado', 400);
        }
        return response()->json(['message' => 'Esporte não encontrado'], 404);
    }

    public function show($esporte_id, string $id)
    {
        try {
            $esporte = Esporte::findOrFail($esporte_id);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }
        try {

            $tipoPontuacao = TipoPontuacao::where('esporte_id', $esporte_id)->where('id', $id)->firstOrFail();

            return new TipoPontuacaoResource($tipoPontuacao);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'TipoPontuacao não encontrado'], 404);
        }


    }

    public function update(Request $request, Esporte $esporte, string $id)
    {
        if ($esporte) {
            $validator = Validator::make($request->all(), [
                'posicao' => 'required|string|max:50',
                'pontuacao_placar' => 'required|boolean',
                'nome_pontuacao' => 'required|string|max:50',
                'valor_pontuacao' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados Invalidos', 422, $validator->errors());
            }


            $data = $validator->validated();

            $updateTipo_usuario = TipoPontuacao::find($id);

            $tipo_pontuacao = $updateTipo_usuario->Update([
                'posicao' => $data['posicao'],
                'pontuacao_placar' => $data['pontuacao_placar'],
                'valor_pontuacao' => $data['valor_pontuacao'],
                'nome_pontuacao' => $data['nome_pontuacao'],
                'esporte_id' => $esporte->id,
            ]);

            return $tipo_pontuacao ? $this->response('Tipo_pontuacao Atualizado', 201, new TipoPontuacaoResource($updateTipo_usuario))
                : $this->error('Tipo_pontuacao nao Atualizado', 400);
        }
        return response()->json(['message' => 'Esporte não encontrado'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($esporte_id, $tipo_pontuacao_id)
    {
        try {
            Esporte::findOrFail($esporte_id);

        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Esporte nao encontrado'], 404);
        }

        $tipo_pontuacao = TipoPontuacao::find($tipo_pontuacao_id);

        $deleted = $tipo_pontuacao->delete();
        return $deleted ? $this->response('TipoPontuacao deletado com sucesso', 200) :
            $this->response('Falha ao deletar TipoPontuacao', 400);
    }
}
