<?php

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Repositories\AdminRepository;
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
