<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models>
 */
class ModelsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . $this->faker->numberBetween(0, 100),
            'brand_id' => $this->faker->numberBetween(1, 3),
            'vehicle_type_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
