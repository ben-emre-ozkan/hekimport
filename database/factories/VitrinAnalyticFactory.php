<?php

namespace Database\Factories;

use App\Models\VitrinAnalytic;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VitrinAnalytic>
 */
class VitrinAnalyticFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VitrinAnalytic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vitrin_id' => Vitrin::factory(),
            'event_type' => $this->faker->randomElement(['view', 'appointment_request', 'contact_click', 'social_click']),
            'source' => $this->faker->randomElement(['direct', 'google', 'social', 'referral']),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'page' => $this->faker->randomElement(['profile', 'services', 'gallery']),
            'metadata' => json_encode(['referrer' => $this->faker->url()]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 