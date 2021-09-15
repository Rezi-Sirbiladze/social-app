<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_PostComment()
    {
        $user = User::factory()->make();
        $post = Post::factory()->make([
            'user_id' => $user->id
        ]);
        $commet = Comment::factory()->make([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $response = $this->json('POST', '/api/Comment', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $commet->contet,
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'user_id',
                    'post_id',
                    'content',
                    'created_at',
                    'updated_at',
                ]);

        $this->assertDatabaseHas('comment', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $commet->contet,
        ]);
    }
}
