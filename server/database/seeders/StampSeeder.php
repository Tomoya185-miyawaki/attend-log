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
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 1, // 出勤
            'stamp_date' => $today . ' 09:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 2, // 退勤
            'stamp_date' => $today . ' 18:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 3, // 休憩開始
            'stamp_date' => $today . ' 12:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 4, // 休憩終了
            'stamp_date' => $today . ' 12:45:00'
        ]);

        DB::table('stamps')->insert([
            'employee_id' => 2,
            'status' => 1, // 出勤
            'stamp_date' => $today . ' 09:00:00'
        ]);
    }
}
