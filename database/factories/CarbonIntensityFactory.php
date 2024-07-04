<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarbonIntensityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country' => 'Hungary',
            'year' => $this->faker->year(),
            'carbon_intensity' => $this->faker->numberBetween(50, 400),
        ];
    }
}
