<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence,
            'message' => fake()->paragraph,
            'user_id' => 1,
            'hall_id' => fake()->numberBetween(1, 10),
            'status' => 'active',
        ];
    }
}
