<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esporte extends Model
{
    use HasFactory;

    protected $table = 'esportes';

    protected $fillable = [
        'nome',
        'status',
    ];

    public function partidas()
    {
        return $this->hasMany(Partida::class, 'esporte_id');
    }

    public function cartas()
    {
        return $this->hasMany(Carta::class, 'esporte_id');
    }

    public function tiposPontuacao()
    {
        return $this->hasMany(TipoPontuacao::class, 'id_esporte');
    }

}
