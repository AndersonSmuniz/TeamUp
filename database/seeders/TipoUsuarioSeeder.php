<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipo_usuarios')->insert([
            ['nome' => 'Administrador'],
            ['nome' => 'Usuário Comum'],
        ]);
    }
}
