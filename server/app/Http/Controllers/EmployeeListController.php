<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;

final class EmployeeListController extends Controller
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $employeeByPaginate = $this->employeeRepositoryInterface->getEmployeesByPage();
        return response()->json([
            'employees' => EmployeeResource::collection($employeeByPaginate),
            'currentPage' => $employeeByPaginate->currentPage(),
            'lastPage' => $employeeByPaginate->lastPage(),
        ]);
    }
}
