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

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    /**
     * @test
     * @return void
     */
    public function ログアウトに成功すること(): void
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
     * @test
     * @return void
     */
    public function 既にログアウト済みの場合はログアウト状態が継続すること(): void
    {
        $this->postJson('/admin/logout')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => '既にログアウトしています',
            ]);

        $this->assertGuest();
    }
}
