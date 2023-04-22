<?php

namespace App\Providers;

use App\Interfaces\CartRepositoryInterface;
use App\Repositories\CartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         // every time to create object from CartModelRepository inside cartcontroller must use name (cart)
        $this->app->bind(CartRepositoryInterface::class, function(){
                return new CartRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
