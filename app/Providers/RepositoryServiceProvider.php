<?php

namespace App\Providers;

use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
            $this->app->bind(RepositoryInterface::class , Repository::class );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
