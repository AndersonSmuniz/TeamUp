<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PartidaResource;
use App\Http\Resources\V1\UsuarioTimeResource;
use App\Models\Estatistica;
use App\Models\Partida;
use App\Models\Resultado;
use App\Models\Time;
use App\Models\UsuarioTime;
use App\Traits\HttpResponses;
use http\Exception\BadMessageException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PartidaController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $partidas = Partida::where('usuario_id', Auth::user()->id)->get();

        return PartidaResource::collection($partidas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'esporte_id' => 'required|exists:esportes,id',
            'nome_time1' => 'required|string',
            'nome_time2' => 'required|string',
            'quantidade_jogadores' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Inválidos', 422, $validator->errors());
        }

        $data = $validator->validated();

        $partida = Partida::create([
            'esporte_id' => $data['esporte_id'],
            'usuario_id' => Auth::user()->id,
            'usuario_juiz_id' => Auth::user()->id,
        ]);

        $time1 = Time::create([
            'nome' => $data['nome_time1'],
            'quantidade_jogadores' => $data['quantidade_jogadores'],
        ]);

        $time2 = Time::create([
            'nome' => $data['nome_time2'],
            'quantidade_jogadores' => $data['quantidade_jogadores'],
        ]);

        $partida->times()->attach([$time1->id, $time2->id]);

        $resultado = Resultado::create([
            'partida_id' => $partida->id,
            'placar' => 0,

        ]);

        $partida->update(['resultado_id' => $resultado->id]);

        return $partida ? $this->response('Partida Cadastrada', 201, new PartidaResource($partida))
            : $this->response('Partida nao Cadastrada', 400);
    }

    public function entrar(Request $request, Partida $partida)
    {
        $usuario = Auth::user();

        $validator = Validator::make($request->all(), [
            'posicao_partida' => 'required',
            'time_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Inválidos', 422, $validator->errors());
        }

        $timesDaPartida = $partida->times->pluck('id')->toArray();

        $usuarioAssociado = UsuarioTime::whereIn('time_id', $timesDaPartida)
            ->where('usuario_id', $usuario->id)
            ->exists();

        if ($usuarioAssociado) {
            return $this->error('Você já está nesta partida', 400);
        } else {

            $UsuarioTime = UsuarioTime::create([
                'usuario_id' => $usuario->id,
                'posicao_partida' => $request['posicao_partida'],
                'time_id' => $request['time_id']
            ]);
        }

        return $this->response('Você entrou na partida com sucesso', 200, new UsuarioTimeResource($UsuarioTime));
    }

    public function show(string $id)
    {
        return new PartidaResource(Partida::where('id', $id)->first());
    }


    public function update(Request $request, string $id)
    {

    }

    public function destroy(Partida $partida)
    {

        $partida->partida_times()->delete();
        $partida->times()->delete();
        $partida->resultado->delete();
        $deleted = $partida->delete();

        return $deleted ? $this->response('Partida deletada com sucesso', 200) :
            $this->response('Falha ao deletar Partida', 400);
    }
}
