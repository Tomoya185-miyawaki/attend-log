<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminListControllerTest extends TestCase
{
    use RefreshDatabase;

    private const CREATE_NUM = 10;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Admin::factory(self::CREATE_NUM)->create();
    }

    /**
     * @test
     * @return void
     */
    public function 正常に処理が完了すること(): void
    {
        $response = $this->get('/api/admins');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonCount(self::CREATE_NUM, 'data');
    }
}
