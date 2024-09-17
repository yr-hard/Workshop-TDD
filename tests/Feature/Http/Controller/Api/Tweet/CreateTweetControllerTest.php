<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTweetControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_terotentikasi_dapat_posting_tweet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweets = Tweet::factory()->make()->toArray();

        $response = $this->postJson('/api/tweet', $tweets);

        $response->assertStatus(200)
            ->assertJson(
                [
                    'user_id' => $user->id,
                    'content' => $tweets['content'],
                ]
            );

        $this->assertDatabaseHas('tweets', [
            'user_id' => $user->id,
            'content' => $tweets['content'],
        ]);
    }

    public function test_user_tidak_terotentikasi_tidak_dapat_posting_tweet(): void
    {
        $tweets = Tweet::factory()->make()->toArray();

        $response = $this->postJson('/api/tweet', $tweets);

        $response->assertStatus(401);
    }
}
