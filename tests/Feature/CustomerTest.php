<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function authenticated_user_can_create_customer()
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
        ])->postJson('/api/customers', [
            'name' => 'John Doe',
            'email' => 'johh@doe.com',
            'phone_number' => '916-259-7147',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', ['name' => 'John Doe']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_retrieve_all_customers()
    {

        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'phone_number']
            ]);
    }
}
