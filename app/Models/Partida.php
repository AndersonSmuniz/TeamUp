<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';

    protected $fillable = [
        'esporte_id',
        'usuario_juiz_id',
        'time_id',
        'usuario_id',
    ];

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function juiz()
    {
        return $this->belongsTo(Usuario::class, 'usuario_juiz_id');
    }

    public function times()
    {
        return $this->belongsToMany(Time::class, 'partida_times', 'partida_id', 'time_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function resultado()
    {
        return $this->hasOne(Resultado::class, 'partida_id');
    }

}
