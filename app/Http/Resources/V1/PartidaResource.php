<?php

namespace App\Http\Resources\V1;

use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartidaResource extends JsonResource
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
            'esporte_id' => $this->esporte_id,
            'usuario_id' => $this->usuario_id,
            'usuario_juiz_id' => $this->usuario_juiz_id,
            'finalizada' => $this->finalizada,
            'resultado' => new ResultadoResource($this->resultado),
            'times' => TimeResource::collection($this->times),
        ];
    }
}
