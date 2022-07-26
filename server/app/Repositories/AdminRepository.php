<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class AdminRepository implements AdminRepositoryInterface
{
    /**
     * 全ての管理者ユーザを取得する
     *
     * @return Collection
     */
    public function getAllAdmins(): Collection
    {
        return Admin::all();
    }
}
