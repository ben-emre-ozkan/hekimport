<?php

namespace Database\Factories;

use App\Models\ForumCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ForumCategoryFactory extends Factory
{
    protected $model = ForumCategory::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(asText: true);
        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            // Add other necessary fields with default values if any
        ];
    }
} 