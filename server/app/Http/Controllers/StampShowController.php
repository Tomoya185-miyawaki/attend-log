<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\Repositories\StampRepositoryInterface;
use App\Utils\StampResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class StampShowController extends Controller
{
    public function __construct(
        private StampRepositoryInterface $stampRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param string $employeeId 従業員ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $employeeId): JsonResponse
    {
        $stampDetails = $this->stampRepositoryInterface->getStampDetail($employeeId);
        if ($stampDetails === null) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '従業員の取得に失敗しました');
        }
        return response()->json([
            'stamps' => StampResource::convertStampDetails($stampDetails['stamps']),
            'employeeName' => $stampDetails['name'],
        ]);
    }
}
