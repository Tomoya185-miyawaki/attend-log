<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

interface StampRepositoryInterface
{
    public function getStampListByPage(string $today): array;
}
