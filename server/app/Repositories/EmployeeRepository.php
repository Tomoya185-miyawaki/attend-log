<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * 全ての管理者ユーザを取得する
     *
     * @return Collection
     */
    public function getEmployeesByPage(): LengthAwarePaginator
    {
        return Employee::orderBy('updated_at', 'desc')->paginate(10);
    }
}
