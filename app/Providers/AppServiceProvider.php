<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define('admin', function (User $user) {
            return $user->role == 'admin';
        });
        Gate::define('penduduk', function (User $user) {
            return $user->role == 'penduduk';
        });
        Gate::define('eksekutor', function (User $user) {
            return $user->role == 'eksekutor';
        });
    }
}
