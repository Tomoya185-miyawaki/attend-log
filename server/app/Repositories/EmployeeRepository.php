<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * 全ての従業員を取得する（更新日でソート）
     *
     * @return Collection
     */
    public function getEmployeesByPage(): LengthAwarePaginator
    {
        return Employee::orderBy('updated_at', 'desc')->paginate(10);
    }

    /**
     * 全ての従業員を取得する
     *
     * @return Collection
     */
    public function getEmployeesByPageNotSort(): LengthAwarePaginator
    {
        return Employee::paginate(10);
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
     * 従業員を作成or更新する
     *
     * @param Employee $employee Employeeモデル
     * @param string $name 従業員名
     * @param int $hourlyWage 時給
     *
     * @return bool 作成に成功or更新にしたかどうか
     */
    public function save(
        Employee $employee,
        string $name,
        int $hourlyWage
    ): bool {
        $employee->name = $name;
        $employee->hourly_wage = $hourlyWage;
        return $employee->save();
    }

    /**
     * 従業員を削除する
     *
     * @param string $id 従業員ID
     *
     * @return int 削除した従業員数
     */
    public function delete(string $id): int
    {
        return Employee::destroy($id);
    }
}
