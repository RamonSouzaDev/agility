<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\StoreService;
use App\Repositories\UserRepository;
use App\Repositories\StoreRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\StoreServiceInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\StoreRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(StoreServiceInterface::class, StoreService::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
