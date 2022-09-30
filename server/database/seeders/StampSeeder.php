<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new Carbon();
        $today = $date->format('Y-m-d');

        // 出勤/休憩/退勤の記録がある
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 1, // 出勤
            'stamp_start_date' => $today . ' 09:00:00',
            'stamp_end_date' => $today . ' 12:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 2, // 退勤
            'stamp_start_date' => $today . ' 13:00:00',
            'stamp_end_date' => $today . ' 18:00:00',
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 3, // 休憩
            'stamp_start_date' => $today . ' 12:00:00',
            'stamp_end_date' => $today . ' 13:00:00'
        ]);

        // 出勤のみ記録がある（休憩なしで働いている）
        DB::table('stamps')->insert([
            'employee_id' => 2,
            'status' => 1, // 出勤
            'stamp_start_date' => $today . ' 09:00:00',
            'stamp_end_date' => $today . ' 18:00:00'
        ]);

        // 出勤（開始時間のみ）の記録がある（午前の仕事中）
        DB::table('stamps')->insert([
            'employee_id' => 3,
            'status' => 1, // 出勤
            'stamp_start_date' => $today . ' 09:00:00',
        ]);

        // 出勤/休憩（開始時間のみ）の記録がある（午前の仕事が終了し、休憩中）
        DB::table('stamps')->insert([
            'employee_id' => 4,
            'status' => 1, // 出勤
            'stamp_start_date' => $today . ' 09:00:00',
            'stamp_end_date' => $today . ' 13:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 4,
            'status' => 3, // 休憩
            'stamp_start_date' => $today . ' 13:00:00',
        ]);

        // 出勤/休憩/退勤（開始時間のみ）の記録がある（午前の仕事・休憩が終了し、午後の仕事中）
        DB::table('stamps')->insert([
            'employee_id' => 5,
            'status' => 1, // 出勤
            'stamp_start_date' => $today . ' 09:00:00',
            'stamp_end_date' => $today . ' 13:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 5,
            'status' => 2, // 退勤
            'stamp_start_date' => $today . ' 14:00:00',
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 5,
            'status' => 3, // 休憩
            'stamp_start_date' => $today . ' 13:00:00',
            'stamp_end_date' => $today . ' 14:00:00',
        ]);
    }
}
