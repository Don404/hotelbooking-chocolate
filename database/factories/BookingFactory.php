<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $checkInDate = $this->faker->dateTimeBetween('now', '+1 year');
        $checkOutDate = (clone $checkInDate)->modify('+'. rand(1, 14) .' days');

        return [
            'room_id' => Room::factory(),
            'customer_id' => Customer::factory(),
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'total_price' => fake()->randomFloat(2, 100, 500)
        ];
    }
}
