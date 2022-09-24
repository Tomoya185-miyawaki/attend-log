<?php

declare(strict_types=1);

namespace Database\Seeders;

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
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 1, // 出勤
            'stamp_date' => '2022-09-24 09:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 2, // 退勤
            'stamp_date' => '2022-09-24 18:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 3, // 休憩開始
            'stamp_date' => '2022-09-24 12:00:00'
        ]);
        DB::table('stamps')->insert([
            'employee_id' => 1,
            'status' => 4, // 休憩終了
            'stamp_date' => '2022-09-24 13:00:00'
        ]);
    }
}
