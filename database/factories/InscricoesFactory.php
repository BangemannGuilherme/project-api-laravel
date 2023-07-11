<?php

namespace Database\Factories;

use App\Models\Inscricoes;
use App\Models\User;
use App\Models\Eventos;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscricoesFactory extends Factory
{
    protected $model = Inscricoes::class;

    public function definition()
    {
        return [
            'users_id' => User::factory(),
            'eventos_id' => Eventos::factory(),
            'checkin' => $this->faker->boolean,
        ];
    }
}