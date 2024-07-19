<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'DemoPass123!'
        ]);

        $response->assertStatus(201)->assertJson([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    public function test_can_get_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_can_get_all_users()
    {
        $users = User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)->assertJsonCount(5);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Jack Sparrow',
            'email' => 'jack@example.com',
        ]);

        $response->assertStatus(200)->assertJson([
            'id' => $user->id,
            'name' => 'Jack Sparrow',
            'email' => 'jack@example.com',
        ]);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
