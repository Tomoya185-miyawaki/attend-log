<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Interfaces\Repositories\StampRepositoryInterface;

final class StampRepository implements StampRepositoryInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface
    ) {
    }

    /**
     * 今日の日付に紐づく出退勤一覧を返す
     *
     * @param string $today 今日の日付（例：2022-01-01）
     *
     * @return array
     */
    public function getStampListByPage(string $today): array
    {
        $employees = $this->employeeRepositoryInterface->getEmployeesByPageNotSort();
        $todayStamps['currentPage'] = $employees->currentPage();
        $todayStamps['lastPage'] = $employees->lastPage();
        $todayStamps['employeeIds'] = $employees->modelKeys();
        $todayStamps['items'] = [];
        foreach ($employees as $employee) {
            $todayStamps['items'][$employee->name] = $employee->stamps->filter(function ($stamp) use ($today) {
                return mb_strpos($stamp['stamp_start_date'], $today) !== false;
            });
        }
        return $todayStamps;
    }

    /**
     * 出退勤の詳細情報を取得する
     *
     * @param string $employeeId 従業員ID
     *
     * @return ?array
     */
    public function getStampDetail(string $employeeId): ?array
    {
        $employee = $this->employeeRepositoryInterface->getEmployeesById($employeeId);
        if ($employee === null) {
            return null;
        }
        $stamps = $employee->stamps->filter(function ($stamp) {
            return $stamp;
        });
        return [
            'name' => $employee->name,
            'stamps' => $stamps
        ];
    }
}
