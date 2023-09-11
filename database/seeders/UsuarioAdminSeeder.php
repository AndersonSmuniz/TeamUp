<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'nome' => 'Admin',
            'apelido' => 'admin',
            'email' => 'admin@admin.com',
            'senha' => Hash::make('password'),
            'celular' => '987654321',
            'tipo_usuario_id' => 1, // Admin
            'midia_social' => 'admin@admin.com/admin',
        ]);
    }
}
