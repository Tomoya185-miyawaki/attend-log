<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => '出勤/休憩/退勤の記録があるユーザー',
            'hourly_wage' => 1000
        ]);
        DB::table('employees')->insert([
            'name' => '出勤のみ記録がある（休憩なしで働いている）ユーザー',
            'hourly_wage' => 1000
        ]);
        DB::table('employees')->insert([
            'name' => '出勤（開始時間のみ）の記録がある（午前の仕事中）ユーザー',
            'hourly_wage' => 1000
        ]);
        DB::table('employees')->insert([
            'name' => '出勤/休憩（開始時間のみ）の記録がある（午前の仕事が終了し、休憩中）ユーザー',
            'hourly_wage' => 1000
        ]);
        DB::table('employees')->insert([
            'name' => '出勤/休憩/退勤（開始時間のみ）の記録がある（午前の仕事・休憩が終了し、午後の仕事中）ユーザー',
            'hourly_wage' => 1000
        ]);
        Employee::factory(10)->create();
    }
}
