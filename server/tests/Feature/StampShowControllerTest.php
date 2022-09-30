<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StampStatus;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Stamp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

final class StampShowControllerTest extends TestCase
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
        $this->employee = Employee::factory()->create([
            'name' => 'test_name'
        ]);
    }

    /**
     *
     * @param array $insertData データベースに挿入する値
     * @param array $expected 期待値
     *
     * @dataProvider stampsDataProvider
     *
     * @return void
     */
    public function test認証済みの場合は正常に処理が完了すること(array $insertData, array $expected): void
    {
        foreach ($insertData as $stamp) {
            Stamp::create([
                'employee_id' => $this->employee->id,
                'status' => $stamp['status'],
                'stamp_start_date' => $stamp['stamp_start_date'],
                'stamp_end_date' => $stamp['stamp_end_date'] ?? null,
            ]);
        }

        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/api/stamp/' . $this->employee->id);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertExactJson([
                    'employeeName' => $this->employee->name,
                    'stamps' => $expected,
                 ]);
    }

    public function stampsDataProvider(): array
    {
        return [
            '全て未入力の場合' => [
                [],
                []
            ],
            '休憩ありのデータが1件の場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 12:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 18:00:00'
                    ],
                ],
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 12:00:00',
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 12:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00',
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 18:00:00',
                    ]
                ]
            ],
            '休憩ありのデータが複数ある場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 12:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 18:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-02 12:00:00',
                        'stamp_end_date' => '2022-01-02 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-02 13:00:00',
                        'stamp_end_date' => '2022-01-02 18:00:00'
                    ],
                ],
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 12:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 18:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-02 12:00:00',
                        'stamp_end_date' => '2022-01-02 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-02 13:00:00',
                        'stamp_end_date' => '2022-01-02 18:00:00'
                    ],
                ]
            ],
            '休憩なしのデータが1件の場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                ],
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                ]
            ],
            '休憩なしのデータが複数件ある場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 17:00:00'
                    ],
                ],
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 17:00:00'
                    ],
                ]
            ],
            '休憩なしのデータと休憩ありのデータがある場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-02 12:00:00',
                        'stamp_end_date' => '2022-01-02 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-02 13:00:00',
                        'stamp_end_date' => '2022-01-02 18:00:00'
                    ],
                ],
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00'
                    ],
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-02 09:00:00',
                        'stamp_end_date' => '2022-01-02 12:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-02 12:00:00',
                        'stamp_end_date' => '2022-01-02 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-02 13:00:00',
                        'stamp_end_date' => '2022-01-02 18:00:00'
                    ],
                ]
            ],
        ];
    }

    /**
     *
     * @return void
     */
    public function test認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->get('/api/stamp/' . $this->employee->id);

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
