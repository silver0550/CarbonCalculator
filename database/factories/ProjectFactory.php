<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'licence_plate' => $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
            'vehicle_id' => Vehicle::factory(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'start_odometer' => $this->faker->numberBetween(1,999),
            'end_odometer' => $this->faker->numberBetween(1000,10000),
        ];
    }
}
