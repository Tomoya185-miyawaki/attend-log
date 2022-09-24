<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class EmployeeDeleteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    /**
     *
     * @return void
     */
    public function test従業員が削除されること(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete('/api/employee/' . $employee->id);

        $response->assertStatus(Response::HTTP_OK);

        $deletedEmployee = Employee::find($employee->id);

        $this->assertSame($deletedEmployee, null);
    }

    /**
     *
     * @return void
     */
    public function test削除対象の従業員が取得できない場合はステータスコード400が返ること(): void
    {
        $this->employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete('/api/employee/' . $this->employee->id + 1);

        $this->assertSame($response->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @return void
     */
    public function test認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->delete('/api/employee/1');

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
