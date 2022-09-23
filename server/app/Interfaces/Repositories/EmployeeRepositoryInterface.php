<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeRepositoryInterface
{
    public function getEmployeesByPage(): LengthAwarePaginator;
    public function getEmployeesById(string $id): Employee|null;
    public function save(
        Employee $employee,
        string $name,
        int $hourlyWage
    ): bool;
}
