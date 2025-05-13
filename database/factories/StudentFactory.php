<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'university' => $this->faker->randomElement(['İstanbul Üniversitesi', 'Ankara Üniversitesi', 'Ege Üniversitesi']),
            'graduation_year' => $this->faker->numberBetween(2025, 2030),
            'bio' => $this->faker->paragraph(),
            'social_links' => json_encode([
                'linkedin' => $this->faker->url(),
                'twitter' => $this->faker->url(),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 