<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Admin::factory(10)->create();
    }
}
