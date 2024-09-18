<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTweetControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    private $user;
    private $anotherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->login();
        $this->anotherUser = User::factory()->create();
    }

    public function test_user_terotentikasi_dapat_mengedit_tweet(): void
    {
        
        $tweet = Tweet::factory()->create(['user_id' => $this->user->id]);

        $updateData = [
            'content' => 'Updated tweet content',
        ];

        $response = $this->putJson("/api/tweet/{$tweet->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'content' => 'Updated tweet content',
                ]
            ]);

        $this->assertDatabaseHas('tweets', [
            'id' => $tweet->id,
            'content' => 'Updated tweet content',
        ]);
    }

    public function test_user_tidak_terotentikasi_tidak_dapat_mengedit_tweet(): void
    {
        $tweet = Tweet::factory()->create();

        $updateData = [
            'content' => 'Updated tweet content',
        ];

        $response = $this->putJson("/api/tweet/{$tweet->id}", $updateData);

        $response->assertStatus(403);
    }

    public function test_user_lain_tidak_dapat_mengedit_tweet(): void
    {
        
        $tweet = Tweet::factory()->create(['user_id' => $this->anotherUser->id]);

        $updateData = [
            'content' => 'Updated tweet content',
        ];

        $response = $this->putJson("/api/tweet/{$tweet->id}", $updateData);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tweets', [
            'id' => $tweet->id,
            'content' => $tweet->content,
        ]);
    }


}
