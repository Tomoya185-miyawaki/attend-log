<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class EmployeeIdControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->employee = Employee::factory()->create();
    }

    /**
     * @test
     *
     * @return void
     */
    public function 認証済みの場合かつ存在するIdの場合は正常に動作すること(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/api/employee/' . $this->employee->id);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                    'employee' => $this->employee->toArray()
                 ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 認証済みの場合かつ存在しないIdの場合はステータスコード400が返ること(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/api/employee/' . $this->employee->id + 1);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->get('/api/employee/' . $this->employee->id);

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
