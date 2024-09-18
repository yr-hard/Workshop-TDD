<?php

namespace Tests\Feature\Http\Controller\Api\Tweet;

use App\Models\Comments;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_dapat_membuat_komentar_di_postingan_sendiri()
    {
        $tweet = Tweet::factory()->create();
        $user = User::factory()->create();
        $comment = Comments::factory()->make();

        $this->actingAs($user);

        $response = $this->postJson("api/tweet/{$tweet->id}/comments", [
            'content' => $comment->content,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
            'content' => $comment->content,
        ]);
    }
}
