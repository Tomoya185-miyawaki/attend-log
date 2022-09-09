<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;

final class EmployeeListController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface
    )
    {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => AdminResource::collection($this->employeeRepositoryInterface->getAllEmployees())
        ]);
    }
}
