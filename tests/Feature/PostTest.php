<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;


class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_GetPost()
    {
        $user = User::factory()->make();
        $post = Post::factory()->make([
            'user_id' => $user->id
        ]);
        $commet = Comment::factory()->make([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $response = $this->json('GET', '/api/post');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'id',
                    'user_id',
                    'content',
                    'created_at',
                    'updated_at',
                    'comments' => [
                        '*' =>[
                            'id',
                            'user_id',
                            'post_id',
                            'content',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]);
    }
}
