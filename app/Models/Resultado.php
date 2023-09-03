<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;
    protected $table = 'resultados';

    protected $fillable = [
        'placar',
        'vencedor',
        'perdedor',
        'partida_id',
    ];

    public function partida()
    {
        return $this->belongsTo(Partida::class, 'partida_id');
    }

}
