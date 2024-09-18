<?php

namespace Tests\Feature\Http\Policies;

use App\Models\Tweet;
use App\Models\User;
use App\Policies\TweetPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetPolicyTest extends TestCase
{
    public function test_user_dapat_mengupdate_tweet(): void
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $policy = new TweetPolicy();
        $this->assertTrue($policy->update($user, $tweet));
        $this->assertFalse($policy->update($userTwo, $tweet));
    }

    public function test_user_dapat_menghapus_tweet(): void
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $policy = new TweetPolicy();
        $this->assertTrue($policy->delete($user, $tweet));
        $this->assertFalse($policy->delete($userTwo, $tweet));
    }
}
