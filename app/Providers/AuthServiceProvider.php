<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('CheckPermission', function ($user, $quote) {
            if($user->is_admin){
                return true;
            }
            return $user->id === $quote->user_id;
        });

        Gate::define('CheckAdmin', function ($user) {
            if($user->is_admin){
                return true;
            }
        });
    }
}
