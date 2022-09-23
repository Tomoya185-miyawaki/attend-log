<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class EmployeeCreateControllerTest extends TestCase
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
        $this->admin = Admin::factory()->create();
    }

    /**
     * @test
     * @return void
     */
    public function 従業員が作成されること(): void
    {
        $params = [
            'name' => '山田太郎',
            'hourlyWage' => 1000,
        ];

        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/api/employee/create', $params);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseCount('employees', 1);
    }

    /**
     * @test
     * @return void
     */
    public function 認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->post('/api/employee/create');

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
