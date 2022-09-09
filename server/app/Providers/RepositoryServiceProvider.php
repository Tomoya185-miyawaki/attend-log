<?php

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\EmployeeRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\EmployeeRepository;
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
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
