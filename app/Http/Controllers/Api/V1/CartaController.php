<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CartaResource;
use App\Http\Resources\V1\EsporteResource;
use App\Models\Carta;
use App\Models\CartaTipoPontuacao;
use App\Models\Esporte;
use App\Models\TipoPontuacao;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Ignition\Tests\TestClasses\Models\Car;

class CartaController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return CartaResource::collection(Carta::all());
    }

    private function NivelCarta($pontosTotal)
    {
        $niveis = [
            'Amador' => 1000,
            'Novato' => 2000,
            'Aspirante' => 3000,
            'Júnior' => 4000,
            'Intermediário' => 5000,
            'Sênior' => 6000,
            'Elite' => 7000,
            'Profissional' => 8000,
            'Lenda' => PHP_INT_MAX,
        ];

        $nivel = 'Amador';

        foreach ($niveis as $nome => $pontosCorte) {
            if ($pontosTotal >= $pontosCorte) {
                $nivel = $nome;
            } else {
                break;
            }
        }

        return $nivel;
    }

    public function CriarCarta(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'esporte_id' => 'required|exists:esportes,id',
            'posicao' => 'required|exists:tipo_pontuacao,posicao',
        ]);

        if ($validator->fails()) {

            return $this->error('Dados Invalidos', 422, $validator->errors());
        }
        $data = $validator->validated();


        $carta = new Carta();
        $carta->esporte_id = $data['esporte_id'];
        $carta->usuario_id = Auth::user()->id;
        $carta->posicao = $data['posicao'];
        $carta->pontos_total = 0;
        $carta->nome = $this->NivelCarta($carta->pontos_total);
        $carta->save();

        // Vê quais tipos de pontuação estão disponíveis para essa posição e pra o esporte
        $tiposPontuacaoDisponiveis = TipoPontuacao::where('esporte_id', $carta->esporte_id)
            ->where('posicao', $carta->posicao)
            ->get();

        // Agora, crie registros CartaTipoPontuacao para cada tipo de pontuação
        foreach ($tiposPontuacaoDisponiveis as $tipoPontuacao) {
            $cartaTipoPontuacao = new CartaTipoPontuacao();
            $cartaTipoPontuacao->tipo_pontuacao_id = $tipoPontuacao->id;
            $cartaTipoPontuacao->valor_pontuacao = 0;
            $cartaTipoPontuacao->carta_id = $carta->id;
            $cartaTipoPontuacao->save();
        }


        return $carta ? $this->response('Carta cadastrada com sucesso', 200, new CartaResource($carta))
            : $this->response('Carta nao cadastrada', 400);

    }

    public function show(string $id)
    {
        //Criar função
    }

    public function destroy($id)
    {
        $carta = Carta::find($id);
        $deleted = $carta->delete();

        return $deleted ? $this->response('Carta deletado com sucesso', 200) :
            $this->response('Falha ao deletar carta', 400);
    }
}
