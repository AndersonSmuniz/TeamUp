<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $table = 'times';

    protected $fillable = [
        'nome',
        'quantidade_jogadores',
        'usuario_time_id',
    ];

    //um-para-muitos
    public function usuariosTime()
    {
        return $this->hasMany(UsuarioTime::class, 'time_id');
    }

    //muitos-para-muitos
    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_times', 'time_id', 'partida_id');
    }

}
