<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
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
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\Eloquents\UserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\CommentRepository::class,
            \App\Repositories\Eloquents\CommentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\FriendRepository::class,
            \App\Repositories\Eloquents\FriendRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\FriendRequestRepository::class,
            \App\Repositories\Eloquents\FriendRequestRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\LikeRepository::class,
            \App\Repositories\Eloquents\LikeRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\NotificationRepository::class,
            \App\Repositories\Eloquents\NotificationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Post::observe(PostObserver::class);
    }
}
