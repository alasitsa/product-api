<?php

namespace App\Providers;

use App\Repositories\HistoryRepository;
use App\Repositories\IHistoryRepository;
use App\Repositories\IProductRepository;
use App\Repositories\IUserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\HistoryService;
use App\Services\IAuthService;
use App\Services\IHistoryService;
use App\Services\IProductService;
use App\Services\IUserService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        IUserRepository::class => UserRepository::class,
        IAuthService::class => AuthService::class,
        IProductRepository::class => ProductRepository::class,
        IProductService::class => ProductService::class,
        IUserService::class => UserService::class,
        IHistoryRepository::class => HistoryRepository::class,
        IHistoryService::class => HistoryService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
