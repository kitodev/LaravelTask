<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/posts', [
            'user_id' => $user->id,
            'title' => 'Post title',
            'body' => 'This is a test post.',
        ]);

        $response->assertStatus(201)->assertJson([
            'title' => 'Post title',
            'body' => 'This is a test post.',
        ]);
    }

    public function test_can_get_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)->assertJson([
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_get_all_posts()
    {
        $posts = Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)->assertJsonCount(5);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated post title',
            'body' => 'Updated post body.',
        ]);

        $response->assertStatus(200)->assertJson([
            'id' => $post->id,
            'title' => 'Updated post title',
            'body' => 'Updated post body.',
        ]);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_can_get_posts_by_user()
    {
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/users/{$user->id}/posts");

        $response->assertStatus(200)->assertJsonCount(3);
    }
}
