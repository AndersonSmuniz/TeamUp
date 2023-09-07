<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaTipoPontuacao extends Model
{
    use HasFactory;

    protected $table = 'carta_tipo_pontuacao';

    protected $fillable = [
        'tipo_pontuacao_id',
        'valor_pontuacao',
        'carta_id',
    ];

    public function carta()
    {
        return $this->belongsTo(Carta::class);
    }

    public function tipoPontuacao()
    {
        return $this->belongsTo(TipoPontuacao::class, 'tipo_pontuacao_id');
    }
}

