<?php

namespace App\Providers;

use App\Repositories\Contracts\MovementRepositoryInterface;
use App\Repositories\MovementRepository;
use App\Services\Contracts\MovementServiceInterface;
use App\Services\Movement\MovementService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovementServiceInterface::class, MovementService::class);
        $this->app->bind(MovementRepositoryInterface::class, MovementRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
