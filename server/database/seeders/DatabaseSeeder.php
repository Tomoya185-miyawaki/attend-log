<?php

namespace Database\Seeders;

use Database\Seeders\AdminSeeder;
use Database\Seeders\EmployeeSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
