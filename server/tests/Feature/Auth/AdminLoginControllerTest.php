<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class AdminLoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function ログインに成功すること(): void
    {
        Admin::factory()->create(['email' => 'test@example.com']);

        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/admin/login', $params);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                    'message' => '認証に成功しました',
                ]);
    }

    /**
     * @test
     * @return void
     */
    public function ログインに失敗すること(): void
    {
        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/admin/login', $params);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                 ->assertJson([
                    'message' => '認証に失敗しました',
                ]);
    }

    /**
     * @test
     * @return void
     */
    public function バリデーションエラーになること(): void
    {
        $response = $this->postJson('/admin/login', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJson([
                    'message' => 'メールアドレスは必ず指定してください。 (and 1 more error)',
                    'errors' => [
                        'email' => ['メールアドレスは必ず指定してください。'],
                        'password' => ['パスワードは必ず指定してください。'],
                    ],
                ]);
    }
}
