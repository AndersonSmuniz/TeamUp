<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoPontuacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nome_pontuacao' => $this->nome_pontuacao,
            'posicao' => $this->posicao,
            'valor_pontuacao' => $this->valor_pontuacao,
            'esporte_id' => $this->esporte_id,
        ];
    }
}
