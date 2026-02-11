<?php

namespace App\Providers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Gate::define('blog-create', function (User $user) {
            return in_array($user->role, [UserRole::ADMIN, UserRole::AUTHOR]);
        });

        Gate::define('category-create', function (User $user) {
            return in_array($user->role, [UserRole::ADMIN]);
        });

        Gate::define('category-edit', function (User $user) {
            return in_array($user->role, [UserRole::ADMIN]);
        });

        Gate::define('category-delete', function (User $user) {
            return in_array($user->role, [UserRole::ADMIN]);
        });

        Gate::define('tag-create', function (User $user) {
            return in_array($user->role, [UserRole::ADMIN]);
        });

        Paginator::useBootstrap();
    }
}
