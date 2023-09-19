<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Estatistica;
use App\Models\Partida;
use App\Models\Resultado;
use App\Models\TipoPontuacao;
use App\Models\Usuario;
use App\Models\UsuarioTime;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PontuacaoController extends Controller
{
    use HttpResponses;
    public function addPontuacao(Request $request, Partida $partida)
    {
        $usuario = Auth::user()->id;


        if ($partida->usuario_juiz_id == $usuario) {

            $validator = Validator::make($request->all(), [
                'usuario_time_id' => 'required|exists:usuario_times,id',
                'tipo_pontuacao_id' => 'required|exists:tipo_pontuacao,id',
                'ponto' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados Invalidos', 422, $validator->errors());
            }

            $usuario_time_id = $request->input('usuario_time_id');
            $tipoPontuacao_id = $request->input('tipo_pontuacao_id');
            $ponto = $request->input('ponto');

            $estatistica = Estatistica::where('usuario_time_id', $usuario_time_id)
                ->where('tipo_pontuacao_id', $tipoPontuacao_id)
                ->first();

            $estatistica->pontos += $ponto;
            $estatistica->save();

            $this->pontuacaoTime($tipoPontuacao_id, $partida->id, $usuario_time_id);

            return response()->json(['message' => 'Pontuação registrada com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Pontuação não cadastrada'], 400);
        }
    }

    private function pontuacaoTime($tipoPontuacao_id, $partida_id, $usuario_time_id)
    {
        $tipoPontuacao = TipoPontuacao::find($tipoPontuacao_id);

        if ($tipoPontuacao && $tipoPontuacao->pontuacao_placar) {
            $resultado = Resultado::where('partida_id', $partida_id)->first();

            if ($resultado) {
                $usuario_time = UsuarioTime::find($usuario_time_id);

                $placarAtual = json_decode($resultado->placar, true);

                if (isset($placarAtual[$usuario_time->time_id])) {
                    $placarAtual[$usuario_time->time_id] += $tipoPontuacao->valor_pontuacao;

                    $placarAtualJson = json_encode($placarAtual);

                    $resultado->placar = $placarAtualJson;

                    $resultado->save();
                }
            }
        }
    }

}
