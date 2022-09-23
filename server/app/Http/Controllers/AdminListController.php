<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use Illuminate\Http\JsonResponse;

final class AdminListController extends Controller
{
    public function __construct(
        private AdminRepositoryInterface $adminRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(
            AdminResource::collection($this->adminRepositoryInterface->getAllAdmins())
        );
    }
}
