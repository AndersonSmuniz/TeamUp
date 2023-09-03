<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use HasFactory;

    protected $table = 'cartas';

    protected $fillable = [
        'usuario_id',
        'esporte_id',
        'posicao',
        'nome',
        'pontos_total',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function tipoPontuacao()
    {
        return $this->belongsToMany(TipoPontuacao::class, 'carta_tipo_pontuacao', 'carta_id', 'tipo_pontuacao_id')
            ->withPivot('quantidade');
    }

}
