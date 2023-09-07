<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPontuacao extends Model
{
    use HasFactory;

    protected $table = 'tipo_pontuacao';

    protected $fillable = [
        'posicao',
        'valor_pontuacao',
        'nome_pontuacao',
        'esporte_id',
    ];

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }
}
