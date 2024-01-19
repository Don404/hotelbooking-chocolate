<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'number' => fake()->unique()->numberBetween($min = 100, $max = 999),
            'type' => fake()->randomElement(['Deluxe', 'Double', 'Single']),
            'price_per_night' => fake()->randomFloat(2, 100, 500),
            'status' => 'available'
        ];
    }
}
