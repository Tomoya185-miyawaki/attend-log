<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{
    public function getAllAdmins(): Collection;
    public function findByEmail(string $email): ?Admin;
    public function save(Admin $admin): bool;
}
