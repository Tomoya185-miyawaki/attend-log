<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class EmployeeUpdateControllerTest extends TestCase
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
    public function test従業員が更新されること(): void
    {
        $employee = Employee::factory()->create();
        $params = [
            'name' => '山田太郎',
            'hourlyWage' => 1000,
        ];

        $response = $this->actingAs($this->admin, 'admin')
                         ->patch('/api/employee/' . $employee->id, $params);

        $response->assertStatus(Response::HTTP_OK);

        $updatedEmployee = Employee::find($employee->id);
        $this->assertSame($params['name'], $updatedEmployee->name);
        $this->assertSame($params['hourlyWage'], $updatedEmployee->hourly_wage);
    }

    /**
     *
     * @return void
     */
    public function test更新対象の従業員が取得できない場合はステータスコード400が返ること(): void
    {
        $this->employee = Employee::factory()->create();
        $params = [
            'name' => '山田太郎',
            'hourlyWage' => 1000,
        ];

        $response = $this->actingAs($this->admin, 'admin')
                         ->patch('/api/employee/' . $this->employee->id + 1, $params);

        $this->assertSame($response->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @return void
     */
    public function test認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->patch('/api/employee/1');

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
