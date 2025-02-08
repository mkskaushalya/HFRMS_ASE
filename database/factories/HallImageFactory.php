<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HallImage>
 */
class HallImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hall_id' => fake()->numberBetween(1, 10),
            'user_id' => 1,
            'title' => fake()->sentence,
            'status' => 'active',
            'url' => fake()->imageUrl(),
        ];
    }
}
