<?php

declare(strict_types=1);

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

    /**
     * メールアドレスから管理者ユーザを取得する
     *
     * @return Admin|null
     */
    public function findByEmail(string $email): ?Admin
    {
        return Admin::where('email', $email)->first();
    }

    /**
     * 管理者ユーザ情報を更新する
     *
     * @return bool
     */
    public function save(Admin $admin): bool
    {
        return $admin->save();
    }
}
