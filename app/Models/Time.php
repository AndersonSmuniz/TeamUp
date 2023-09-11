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
    ];

    //um-para-muitos
    public function usuariosTime()
    {
        return $this->hasMany(UsuarioTime::class, 'time_id');
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_time');
    }

    public function partida_times()
    {
        return $this->hasMany(PartidaTime::class);
    }

}
