<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'apelido' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'senha' => bcrypt('password'),
            'tipo_usuario_id' => 2,
            'celular' => $this->faker->phoneNumber,
            'midia_social' => $this->faker->url,
        ];
    }
}

