<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this->nome,
            'posicao' => $this->posicao,
            'pontos_total' => $this->pontos_total,
            'usuario_id' => $this->usuario_id,
            'esporte_id' => $this->esporte_id,
        ];
    }
}
