<?php

namespace App\Providers;

use App\Services\StoreService;
use App\Repositories\StoreRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\StoreServiceInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
