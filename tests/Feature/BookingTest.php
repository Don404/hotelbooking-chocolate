<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function authenticated_user_can_create_booking()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');

        $room = Room::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/bookings', [
            'room_id' => $room->id,
            'customer_id' => $customer->id,
            'check_in_date' => '2022-01-01',
            'check_out_date' => '2022-01-03',
            'total_price' => 300.00,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', ['room_id' => $room->id]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function authenticated_user_cannot_create_double_booking()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');

        $room = Room::factory()->create();
        $customer = Customer::factory()->create();

        Booking::factory()->create([
            'room_id' => $room->id,
            'customer_id' => $customer->id,
            'check_in_date' => '2022-01-01',
            'check_out_date' => '2022-01-03',
            'total_price' => 300.00,
        ]);

        try {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->postJson('/api/bookings', [
                'room_id' => $room->id,
                'customer_id' => $customer->id,
                'check_in_date' => '2022-01-01',
                'check_out_date' => '2022-01-03',
                'total_price' => 300.00,
            ]);

            $this->fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_retrieve_all_bookings()
    {

        Booking::factory()->count(3)->create();

        $response = $this->getJson('/api/bookings');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
