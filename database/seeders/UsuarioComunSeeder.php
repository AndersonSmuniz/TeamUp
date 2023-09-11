<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioComunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('usuarios')->insert([
                'nome' => $faker->userName,
                'apelido' => $faker->unique()->firstName,
                'email' => $faker->unique()->safeEmail,
                'senha' => Hash::make('password'),
                'celular' => $faker->phoneNumber,
                'tipo_usuario_id' => 2,
                'midia_social' => $faker->url,
            ]);
        }
    }
}
