<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class EmployeeIdController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param string $id 従業員ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $id): JsonResponse
    {
        $employee = $this->employeeRepositoryInterface->getEmployeesById($id);
        if ($employee === null) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '従業員の取得に失敗しました');
        }
        return response()->json([
            'employee' => new EmployeeResource($employee),
        ]);
    }
}
