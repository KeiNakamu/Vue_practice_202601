<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * ユーザー作成テスト
     */
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * ログインテスト
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertJsonStructure([
            'data' => [
                'message',
                'token',
                'token_type',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at'
                ]
            ]
        ]);
    }

    /**
     * ログイン失敗テスト
     */
    public function test_login_fails_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    /**
     * 認証成功テスト
     */
    public function test_authenticated_user_can_access_me()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
                        ->getJson('/api/me');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ]
                ])
                ->assertJsonMissingPath('data.password');
    }

    /**
     * 認証失敗テスト
     */
    public function test_unauthenticated_user_cannot_access_me()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401);
    }
}
