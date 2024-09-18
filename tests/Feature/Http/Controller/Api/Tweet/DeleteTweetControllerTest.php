<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTweetControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $anotherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->login();
        $this->anotherUser = User::factory()->create();
    }

    public function test_user_terotentikasi_dapat_menghapus_tweet(): void
    {
        $tweet = Tweet::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson('/api/tweet/' . $tweet->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Tweet deleted successfully',
            ]);

        $this->assertDatabaseMissing('tweets', [
            'id' => $tweet->id,
        ]);
    }

    public function test_user_tidak_terotentikasi_tidak_dapat_menghapus_tweet(): void
    {
        $tweet = Tweet::factory()->create();

        $response = $this->deleteJson('/api/tweet/' . $tweet->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tweets', [
            'id' => $tweet->id,
        ]);
    }

    public function test_user_tidak_dapat_menghapus_tweet_orang_lain(): void
    {
        $tweet = Tweet::factory()->create();

        $response = $this->deleteJson('/api/tweet/' . $tweet->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tweets', [
            'id' => $tweet->id,
        ]);
    }
}
