<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserProfileObserver;
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
        User::observe(UserProfileObserver::class);

        Gate::define('isAdmin', function (User $user) {
            return $user->level === 'admin';
        });
    }
}
