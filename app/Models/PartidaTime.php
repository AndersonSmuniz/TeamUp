<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartidaTime extends Model
{
    use HasFactory;

    protected $table = 'partida_time';

    public function partidas()
    {
        return $this->belongsToMany(Partida::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
