<?php

namespace Database\Factories;

use App\Models\ProfileVisit;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfileVisit>
 */
class ProfileVisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfileVisit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vitrin_id' => Vitrin::factory(),
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'referrer' => $this->faker->randomElement([
                'https://google.com',
                'https://facebook.com',
                'https://hekimport.com',
                'https://twitter.com',
                'https://instagram.com',
                null
            ]),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
    
    /**
     * Configure the factory to create visits from today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => $this->faker->dateTimeBetween('-23 hours', 'now'),
        ]);
    }
    
    /**
     * Configure the factory to create visits from a specific date range.
     */
    public function inDateRange(string $start, string $end): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => $this->faker->dateTimeBetween($start, $end),
        ]);
    }
} 