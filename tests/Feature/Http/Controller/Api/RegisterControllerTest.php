<?php

namespace Tests\Feature\Http\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_dapat_melakukan_register(): void
    {
        $response = $this->postJson('/api/register',[
            'name' => 'yusuf',
            'email' => 'yusuf@email.com',
            'password' => '12345qwert',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'yusuf',
                'email' => 'yusuf@email.com'
            ]);
    }
}
