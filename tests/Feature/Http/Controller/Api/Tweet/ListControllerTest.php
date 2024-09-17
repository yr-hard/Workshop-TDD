<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_terotentikasi_dapat_melihat_daftar_tweet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tweets = Tweet::factory()->count(2)->create();

        $response = $this->getJson('/api/tweet/list');

        $this->assertDatabaseCount('tweets',2);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' =>
                [[
                    'user_id',
                    'content'
                ]]
            ]);
    }

    public function test_guest_tidak_dapat_melihat_daftar_tweet(): void
    {
        $response = $this->getJson('/api/tweet/list');

        $response->assertStatus(401);
    }
    
}
