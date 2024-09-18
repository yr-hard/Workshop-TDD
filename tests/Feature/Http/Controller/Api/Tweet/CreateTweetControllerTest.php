<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\UploadedFile;
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
        $user = $this->login();

        $tweets = Tweet::factory()->make()->toArray();

        $response = $this->postJson('/api/tweet', $tweets);

        $response->assertStatus(201)
            ->assertJsonStructure(
                [ 'data' => [
                        'user_id',
                        'content',
                        'photo', // Assuming the response contains a photo URL
                    ]
                ]
            );

        $this->assertDatabaseHas('tweets', [
            'user_id' => $user->id,
            'content' => $tweets['content'],
        ]);
    }

    public function test_user_terotentikasi_dapat_posting_tweet_dan_upload_photo(): void
    {
        $user = $this->login();

        $tweets = Tweet::factory()->make()->toArray();
        $photo = UploadedFile::fake()->image('photo.jpg');

        $response = $this->postJson('/api/tweet', array_merge($tweets, ['photo' => $photo]));

        $response->assertStatus(201)
            ->assertJsonStructure(
                ['data' => [
                        'user_id',
                        'content',
                        'photo', // Assuming the response contains a photo URL
                    ]
                ]
            );

        $this->assertDatabaseHas('tweets', [
            'user_id' => $user->id,
            'content' => $tweets['content'],
            // Assuming there is a column for photo URL in the tweets table
        ]);
    }

    public function test_tweet_harus_berisi_konten(): void
    {
        $this->login();

        $tweets = Tweet::factory()->make(['content' => ''])->toArray();

        $response = $this->postJson('/api/tweet', array_merge($tweets));

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['content']]);
    }

    public function test_user_tidak_terotentikasi_tidak_dapat_posting_tweet(): void
    {
        $tweets = Tweet::factory()->make()->toArray();

        $response = $this->postJson('/api/tweet', $tweets);

        $response->assertStatus(401);
    }
}
