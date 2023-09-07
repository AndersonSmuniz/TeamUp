<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
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
            'apelido' => $this->apelido,
            'email' => $this->email,
            'celular'=> $this->celular,
            'midia_social' => $this->midia_social,
            'Tipo_usuario' => $this->tipo_usuario_id,
        ];
    }
}
