<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class EmployeeCreateController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface,
        private Employee $employee
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param EmployeeCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(EmployeeCreateRequest $request): JsonResponse
    {
        $isCreate = $this->employeeRepositoryInterface->save(
            $this->employee,
            $request->input('name'),
            (int) $request->input('hourlyWage')
        );
        if ($isCreate) {
            return response()->json('従業員作成に成功しました');
        }
        throw new HttpException(Response::HTTP_BAD_REQUEST, '従業員作成に失敗しました');
    }
}
