<?php

namespace Database\Factories;

use App\Models\CustomDomain;
use App\Models\Vitrin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomDomain>
 */
class CustomDomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomDomain::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vitrin_id' => Vitrin::factory(),
            'domain' => $this->faker->unique()->domainName(),
            'is_verified' => $this->faker->boolean(),
            'verification_token' => $this->faker->optional()->sha256(),
            'dns_checked_at' => $this->faker->optional()->dateTimeThisMonth(),
        ];
    }
}
