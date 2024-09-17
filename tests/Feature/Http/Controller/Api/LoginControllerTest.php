<?php

namespace Tests\Feature\Http\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_login_dengan_kredensial_benar(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email
            ]);
    }

    public function test_user_login_dengan_kredensial_salah(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'abcde'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'username / password salah'
            ]);
    }
}
