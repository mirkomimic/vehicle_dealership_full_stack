<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
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
            // 'model_id' => $this->faker->word() . $this->faker->numberBetween(0, 100),
            'model_id' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->numberBetween(2000, 100000),
            'year' => $this->faker->numberBetween(2000, date('Y')),
            'mileage' => $this->faker->numberBetween(0, 100000),
        ];
    }
}
