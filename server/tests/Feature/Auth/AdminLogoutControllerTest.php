<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class AdminLogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    /**
     *
     * @return void
     */
    public function testログアウトに成功すること(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->postJson('/admin/logout');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                    'message' => 'ログアウトに成功しました',
                 ]);

        $this->assertGuest();
    }

    /**
     *
     * @return void
     */
    public function test既にログアウト済みの場合はログアウト状態が継続すること(): void
    {
        $this->postJson('/admin/logout')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => '既にログアウトしています',
            ]);

        $this->assertGuest();
    }
}
