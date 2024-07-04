<?php

namespace Database\Factories;

use App\Enums\FuelTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;


class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->year(),
            'manufacturer' => $this->faker->company(),
            'model' => $this->faker->name(),
            'type' => $this->faker->name(),
            'fuel_type' => $this->faker->randomElement(getEnumValues(FuelTypeEnum::class)),
            'wltp_energy_consumption' => $this->faker->boolean() ? $this->faker->numberBetween(1,200) : null,
            'nedc_energy_consumption' => $this->faker->boolean() ? $this->faker->numberBetween(1,100) : null,
        ];
    }
}
