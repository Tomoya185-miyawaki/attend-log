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

final class StampListControllerTest extends TestCase
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
                         ->get('/api/stamp?today=2022-01-01');

        $response->assertStatus(Response::HTTP_OK)
                 ->assertExactJson([
                    'currentPage' => 1,
                    'employeeIds' => [$this->employee->id],
                    'stamps' => $expected,
                    'lastPage' => 1
                 ]);
    }

    public function stampsDataProvider(): array
    {
        return [
            '全て未入力の場合' => [
                [],
                [
                    'test_name' => [
                        'attend_date' => '-',
                        'leaving_date' => '-',
                        'rest_date' => '-',
                        'working_date' => '-'
                    ]
                ]
            ],
            '午前の仕事中の場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00'
                    ]
                ],
                [
                    'test_name' => [
                        'attend_date' => '9時00分',
                        'leaving_date' => '-',
                        'rest_date' => '-',
                        'working_date' => '-'
                    ]
                ]
            ],
            '午前の仕事が終わり、休憩中の場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 13:00:00'
                    ]
                ],
                [
                    'test_name' => [
                        'attend_date' => '9時00分',
                        'leaving_date' => '-',
                        'rest_date' => '-',
                        'working_date' => '-'
                    ]
                ]
            ],
            '午前・休憩の仕事が終わり、午後の仕事中の場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 14:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 14:00:00'
                    ]
                ],
                [
                    'test_name' => [
                        'attend_date' => '9時00分',
                        'leaving_date' => '-',
                        'rest_date' => '1時間00分',
                        'working_date' => '-'
                    ]
                ]
            ],
            '午前・休憩・午後の仕事が終わっている場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 13:00:00'
                    ],
                    [
                        'status' => StampStatus::Rest->value,
                        'stamp_start_date' => '2022-01-01 13:00:00',
                        'stamp_end_date' => '2022-01-01 14:00:00'
                    ],
                    [
                        'status' => StampStatus::Leaving->value,
                        'stamp_start_date' => '2022-01-01 14:00:00',
                        'stamp_end_date' => '2022-01-01 18:00:00'
                    ]
                ],
                [
                    'test_name' => [
                        'attend_date' => '9時00分',
                        'leaving_date' => '18時00分',
                        'rest_date' => '1時間00分',
                        'working_date' => '8時間00分'
                    ]
                ]
            ],
            '休憩をせずに仕事を終わっている場合' => [
                [
                    [
                        'status' => StampStatus::Attend->value,
                        'stamp_start_date' => '2022-01-01 09:00:00',
                        'stamp_end_date' => '2022-01-01 17:00:00',
                    ],
                ],
                [
                    'test_name' => [
                        'attend_date' => '9時00分',
                        'leaving_date' => '17時00分',
                        'rest_date' => '-',
                        'working_date' => '8時間00分'
                    ]
                ]
            ]
        ];
    }

    /**
     *
     * @return void
     */
    public function test認証していない場合は302リダイレクトすること(): void
    {
        $response = $this->get('/api/stamp?today=2022-01-01');

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
