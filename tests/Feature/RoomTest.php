<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function authenticated_user_can_create_room()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/rooms', [
            'number' => '101',
            'type' => 'Deluxe',
            'price_per_night' => 100.00,
            'status' => 'available',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('rooms', ['number' => '101']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_retrieve_all_rooms()
    {

        Room::factory()->count(3)->create();

        $response = $this->getJson('/api/rooms');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'number', 'type', 'price_per_night', 'status']
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_view_details_of_a_specific_room()
    {
        $room = Room::factory()->create();
        $response = $this->getJson('/api/rooms/' . $room->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $room->id,
                'number' => $room->number,
                'type' => $room->type,
                'price_per_night' => $room->price_per_night,
                'status' => $room->status,
            ]);
    }
}
