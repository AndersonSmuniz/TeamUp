<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatistica extends Model
{
    use HasFactory;

    protected $table = 'estatisticas';

    protected $fillable = [
        'pontos',
        'usuario_time_id',
        'tipo_pontuacao_id',
    ];

    public function usuarioTime()
    {
        return $this->belongsTo(UsuarioTime::class, 'usuario_time_id');
    }

}
