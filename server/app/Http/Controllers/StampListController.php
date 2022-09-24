<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\Repositories\StampRepositoryInterface;
use App\Utils\StampResource;
use Illuminate\Http\JsonResponse;

final class StampListController extends Controller
{
    public function __construct(
        private StampRepositoryInterface $stampRepositoryInterface
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $stampListByPaginate = $this->stampRepositoryInterface->getStampListByPage(request()->get('today'));
        return response()->json([
            'stamps' => StampResource::convertStampList($stampListByPaginate['items']),
            'currentPage' => $stampListByPaginate['currentPage'],
            'lastPage' => $stampListByPaginate['lastPage'],
        ]);
    }
}
