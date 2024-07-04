<?php

namespace Database\Factories;

use App\Enums\FuelTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'year' => $this->faker->year(),
            'manufacturer' => $this->faker->company(),
            'model' => $this->faker->name(),
            'type' => $this->faker->name(),
            'fuel_type' => $this->faker->randomElement(getEnumValues(FuelTypeEnum::class)),
            'wltp_energy_consumption' => $this->faker->numberBetween(1,200),
            'nedc_energy_consumption' => $this->faker->numberBetween(1,100),
        ];
    }
}
