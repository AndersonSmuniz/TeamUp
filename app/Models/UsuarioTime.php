<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTime extends Model
{
    use HasFactory;

    protected $table = 'usuario_times';

    protected $fillable = [
        'time_id',
        'posicao_partida',
        'usuario_id',
    ];

    //muitos-para-um
    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

}
