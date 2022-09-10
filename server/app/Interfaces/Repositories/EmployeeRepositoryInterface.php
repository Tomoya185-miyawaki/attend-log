<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeRepositoryInterface
{
    public function getEmployeesByPage(): LengthAwarePaginator;
}
