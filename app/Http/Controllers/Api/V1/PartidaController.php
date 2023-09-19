<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PartidaResource;
use App\Http\Resources\V1\ResultadoResource;
use App\Http\Resources\V1\UsuarioTimeResource;
use App\Models\Estatistica;
use App\Models\Partida;
use App\Models\Resultado;
use App\Models\Time;
use App\Models\TipoPontuacao;
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
            'finalizada' => false,
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

        $placarInicial = [
            $time1->id => 0,
            $time2->id => 0,
        ];

        $resultado = Resultado::create([
            'partida_id' => $partida->id,
            'placar' => json_encode($placarInicial),
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

            $usuarioTime = UsuarioTime::create([
                'usuario_id' => $usuario->id,
                'posicao_partida' => $request['posicao_partida'],
                'time_id' => $request['time_id']
            ]);

            $usuarioTime_id = $usuarioTime->id;

            $estatisticas = [];

            $tiposPontuacao = TipoPontuacao::where('esporte_id', $partida->esporte_id)->get();

            foreach ($tiposPontuacao as $tipoPontuacao) {
                $estatisticas[] = [
                    'usuario_time_id' => $usuarioTime_id,
                    'tipo_pontuacao_id' => $tipoPontuacao->id,
                    'pontos' => 0,
                ];
            }
            Estatistica::insert($estatisticas);
        }

        return $this->response('Você entrou na partida com sucesso', 200, new UsuarioTimeResource($usuarioTime));
    }

    public function finalizarPartida(Partida $partida)
    {
        $usuario = Auth::user()->id;

        if ($usuario == $partida->usuario_juiz_id && !($partida->finalizada)) {
            $resultado = Resultado::where('partida_id', $partida->id)->first();

            if ($resultado) {
                $placar = json_decode($resultado->placar, true); // Decodificando JSON

                $timeIds = array_keys($placar);
                $pontos = array_values($placar);

                $vencedor = array_search(max($pontos), $pontos);
                $perdedor = array_search(min($pontos), $pontos);

                if ($vencedor !== false && $perdedor !== false) {
                    $times = Time::whereIn('id', [$timeIds[$vencedor], $timeIds[$perdedor]])->get();
                    if ($vencedor !== $perdedor) {
                        $resultado->vencedor = $times[0]->nome;
                        $resultado->perdedor = $times[1]->nome;
                    }else{
                        $resultado->vencedor = 'empate';
                        $resultado->perdedor = 'empate';
                    }
                    $partida->finalizada = true;

                    $partida->save();
                    $resultado->save();
                }
                return $this->response('Partida finalizada', 200, new ResultadoResource($resultado));
            }
            return $this->response('Erro ao finalizar Partida', 400);
        }
        return $this->response('Só o juiz pode finalizar partida ou a partida já foi finalizada', 400);
    }

    public function show(string $id)
    {
        return new PartidaResource(Partida::where('id', $id)->first());
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
