<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Models\Employee;
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
     * Idから従業員を取得する
     *
     * @param string $id 従業員Id
     *
     * @return Employee|null
     */
    public function getEmployeesById(string $id): Employee|null
    {
        return Employee::find($id);
    }

    /**
     * 従業員を作成する
     *
     * @param Employee $employee Employeeモデル
     * @param string $name 従業員名
     * @param int $hourlyWage 時給
     *
     * @return bool 作成に成功したかどうか
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
