<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'amigos_id',
        'pedidos_amizade',
    ];

    protected $casts = [
        'pedidos_amizade' => 'array',
        'amigos_id' => 'array'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function amigos()
    {
        return $this->belongsToMany(User::class, 'amigos', 'usuario_id', 'amigos_id');
    }

}
