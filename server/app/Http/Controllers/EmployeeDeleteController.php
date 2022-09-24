<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class EmployeeDeleteController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface,
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
        $isDelete = $this->employeeRepositoryInterface->delete($id) > 0;
        if ($isDelete) {
            return response()->json('従業員の削除に成功しました');
        }
        throw new HttpException(Response::HTTP_BAD_REQUEST, '従業員の削除に失敗しました');
    }
}
