<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * 全ての管理者ユーザを取得する
     *
     * @return Collection
     */
    public function getAllEmployees(): Collection
    {
        return Employee::all();
    }
}
