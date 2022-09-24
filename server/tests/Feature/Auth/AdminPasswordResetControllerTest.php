<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class AdminPasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create(['email' => 'test@example.com']);
    }

    /**
     *
     * @return void
     */
    public function testバリデーションエラーになること(): void
    {
        $response = $this->postJson('/api/admin/password-reset', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJson([
                    'message' => 'メールアドレスは必ず指定してください。 (and 1 more error)',
                    'errors' => [
                        'email' => ['メールアドレスは必ず指定してください。'],
                        'password' => ['パスワードは必ず指定してください。'],
                    ],
                ]);
    }

    /**
     *
     * @return void
     */
    public function test既にログイン済みの場合はエラーになること(): void
    {
        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->actingAs($this->admin, 'admin')
                         ->postJson('/api/admin/password-reset', $params);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
                 ->assertJson([
                    'message' => '既にログインしています',
                ]);
    }

    /**
     *
     * @return void
     */
    public function test対象の管理者ユーザが存在しない場合はエラーになること(): void
    {
        $params = [
            'email' => 'test2@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/admin/password-reset', $params);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
                 ->assertJson([
                    'message' => 'メールアドレスが存在しません',
                ]);
    }

    /**
     *
     * @return void
     */
    public function testパスワードリセットに成功すること(): void
    {
        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/admin/password-reset', $params);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                    'message' => 'パスワードの更新に成功しました',
                ]);
    }
}
