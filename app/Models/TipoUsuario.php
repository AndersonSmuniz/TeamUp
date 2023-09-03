<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuarios';

    protected $guarded = [];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'tipo_usuario_id');
    }


    public static function administradorId()
    {
        return self::where('nome', 'Administrador')->value('id');
    }

    public static function usuarioComumId()
    {
        return self::where('nome', 'Usuário Comum')->value('id');
    }
}
