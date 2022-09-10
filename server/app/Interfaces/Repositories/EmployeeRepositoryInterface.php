<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface
{
    public function getAllEmployees(): Collection;
}
