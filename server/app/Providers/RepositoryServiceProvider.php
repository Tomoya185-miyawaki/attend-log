<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Interfaces\Repositories\StampRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\StampRepository;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->singleton(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->singleton(StampRepositoryInterface::class, StampRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
