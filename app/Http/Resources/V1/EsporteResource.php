<?php

namespace App\Http\Resources\V1;

use App\Models\Esporte;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EsporteResource extends JsonResource
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
          'status' => $this->status,
        ];
    }
}
