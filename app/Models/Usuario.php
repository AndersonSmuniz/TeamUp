<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

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

    public static $rules = [
        'nome' => 'required|string|max:255',
        'apelido' => 'required|string|max:50|unique:usuarios',
        'email' => 'required|email|unique:usuarios',
        'senha' => 'required|min:6',
        'celular' => 'nullable',
        'tipo_usuario_id' => 'required|exists:tipo_usuarios,id',
        'midia_social' => 'nullable|string|max:255',
    ];

    public static $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'unique' => 'O :attribute já está em uso.',
        'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
        'exists' => 'O :attribute selecionado é inválido.',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id');
    }

    //tipo de usuário fixo durante a criação
    //função boot() chamada na criação de um novo usuario
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            if (!$usuario->tipo_usuario_id) {
                $usuario->tipo_usuario_id = TipoUsuario::usuarioComumId();
            }
        });
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
