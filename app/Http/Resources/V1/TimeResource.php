<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'quantidade_jogadores' => $this->quantidade_jogadores,
            'jogadores' => $this->usuariosTime->map(function ($usuarioTime) {
                return [
                    'id' => $usuarioTime->usuario->id,
                    'Apelido' => $usuarioTime->usuario->apelido,
                    'posicao_partida' => $usuarioTime->posicao_partida,
                ];
            }),
        ];
    }
}
