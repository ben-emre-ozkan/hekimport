<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vitrin_id' => Vitrin::factory(),
            'name' => $this->faker->bs(), // Business service name
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 50, 1000),
        ];
    }
}
