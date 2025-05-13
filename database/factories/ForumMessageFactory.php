<?php

namespace Database\Factories;

use App\Models\ForumMessage;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumMessageFactory extends Factory
{
    protected $model = ForumMessage::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => ForumTopic::factory(),
            'content' => $this->faker->paragraphs(asText: true),
            // Add other necessary fields with default values if any
        ];
    }
} 