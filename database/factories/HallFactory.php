<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hall>
 */
class HallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'hall_number' => fake()->unique()->numberBetween(100, 999),
            'hall_location_id' => fake()->numberBetween(1, 4),
            'capacity' => fake()->numberBetween(20, 500),
            'price' => fake()->numberBetween(15000, 50000),
            'description' => fake()->paragraph,
            'status' => 'active',
            'image' => fake()->imageUrl(),
            'user_id' => 1,
        ];

    }
}
