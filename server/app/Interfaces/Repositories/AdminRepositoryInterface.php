<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{
    public function getAllAdmins(): Collection;
}
