<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class AdminListControllerTest extends TestCase
{
    use RefreshDatabase;

    private const CREATE_NUM = 10;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory(self::CREATE_NUM)->create();
    }

    /**
     *
     * @return void
     */
    public function test認証済みの場合は正常に処理が完了すること(): void
    {
        $response = $this->actingAs($this->admin[0], 'admin')
                         ->get('/api/admin');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonCount(self::CREATE_NUM);
    }

    /**
     *
     * @return void
     */
    public function test認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->get('/api/admin');

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
