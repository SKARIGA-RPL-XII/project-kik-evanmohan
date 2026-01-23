<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate untuk admin
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';   // sesuaikan dengan kolom di tabel users
        });

        // Gate untuk user biasa
        Gate::define('isUser', function ($user) {
            return $user->role === 'customer'; // contoh, bisa disesuaikan
        });
    }
}
