<?php

namespace Database\Factories;

use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ForumTopicFactory extends Factory
{
    protected $model = ForumTopic::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence();
        return [
            'user_id' => User::factory(),
            'category_id' => ForumCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'is_pinned' => false,
            // Add other necessary fields with default values if any
        ];
    }
} 