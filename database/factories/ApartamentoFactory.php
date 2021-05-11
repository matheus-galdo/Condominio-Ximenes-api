<?php

namespace Database\Factories;

use App\Models\Apartamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Apartamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bloco' => $this->faker->realText(10),
            'numero' => $this->faker->buildingNumber(),
            'andar' => rand(0, 8)
        ];
    }
}
