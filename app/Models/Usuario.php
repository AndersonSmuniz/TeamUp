<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'apelido',
        'email',
        'senha',
        'celular',
        'tipo_usuario_id',
        'midia_social',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id');
    }


    public function cartas()
    {
        return $this->hasMany(Carta::class, 'usuario_id');
    }

    public function partidasJogadas()
    {
        return $this->hasMany(Partida::class, 'usuario_id');
    }

    public function partidasJuiz()
    {
        return $this->hasMany(Partida::class, 'usuario_juiz_id');
    }

    public function times()
    {
        return $this->hasMany(UsuarioTime::class, 'usuario_id');
    }

}
