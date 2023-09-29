<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Contracts\PostRepository::class,
            \App\Repositories\Eloquents\PostRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\ImageRepository::class,
            \App\Repositories\Eloquents\ImageRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
