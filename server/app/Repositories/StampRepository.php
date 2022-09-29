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
                return mb_strpos($stamp['stamp_date'], $today) !== false;
            });
        }
        return $todayStamps;
    }
}
