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

    /**
     * 従業員を作成する
     *
     * @param Employee $employee Employeeモデル
     * @param string $name 従業員名
     * @param integer $hourlyWage 時給
     * @return boolean 作成に成功したかどうか
     */
    public function create(
        Employee $employee,
        string $name,
        int $hourlyWage
    ): bool {
        $employee->name = $name;
        $employee->hourly_wage = $hourlyWage;
        return $employee->save();
    }
}
