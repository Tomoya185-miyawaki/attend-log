<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeUpdateRequest;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class EmployeeUpdateController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface,
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param EmployeeUpdateRequest $request
     * @param string $id 従業員ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(EmployeeUpdateRequest $request, string $id): JsonResponse
    {
        $employee = $this->employeeRepositoryInterface->getEmployeesById($id);
        if ($employee === null) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '更新時に従業員の取得に失敗しました');
        }
        $isUpdate = $this->employeeRepositoryInterface->save(
            $employee,
            $request->input('name'),
            (int) $request->input('hourlyWage')
        );
        if ($isUpdate) {
            return response()->json('従業員の更新に成功しました');
        }
        throw new HttpException(Response::HTTP_BAD_REQUEST, '従業員の更新に失敗しました');
    }
}
