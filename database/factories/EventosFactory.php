<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eventos>
 */
class EventosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $data_inicial = Carbon::parse('2023-04-28');
        $data_final = Carbon::parse('2023-05-10');

        return [
            'nome' => fake()->name(),
            'descricao' => fake()->realText(),
            'data_inicial' => $data_inicial,
            'data_final' => $data_final,
        ];
    }
}
