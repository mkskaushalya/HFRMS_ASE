<?php

namespace Database\Factories;

use App\Models\HallBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HallBooking>
 */
class HallBookingFactory extends Factory
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
            'user_id' => fake()->numberBetween(1, 10),
            'booking_date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'status' => 'pending',
            'purpose' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'payment' => 0,
        ];
    }
}
