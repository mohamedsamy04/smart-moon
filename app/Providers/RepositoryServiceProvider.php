<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\DirectCheckoutRepositoryInterface;
use App\Repositories\Interfaces\AdminOrderRepositoryInterface;
use App\Repositories\Interfaces\CartCheckoutRepositoryInterface;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\CategoryRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\CartRepository;
use App\Repositories\Eloquents\DirectCheckoutRepository;
use App\Repositories\Eloquents\AdminOrderRepository;
use App\Repositories\Eloquents\CartCheckoutRepository;
use App\Repositories\Eloquents\DashboardRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(DirectCheckoutRepositoryInterface::class, DirectCheckoutRepository::class);
        $this->app->bind(AdminOrderRepositoryInterface::class, AdminOrderRepository::class);
        $this->app->bind(CartCheckoutRepositoryInterface::class, CartCheckoutRepository::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
