<?php

namespace Database\Factories;

use App\Models\Service; // Import Service model
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('##########'), // 10 digits
            'date' => $this->faker->dateTimeBetween('+1 day', '+1 month'), // Future date
            'service_id' => Service::factory(), // Create a service or use an existing one
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            // 'vitrin_id' => Vitrin::factory(), // If applicable
        ];
    }
}
