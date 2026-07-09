<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- VÉRIFIEZ BIEN CETTE LIGNE EXACTEMENT ICI

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
        // Forcer l'utilisation de Bootstrap 5 pour la pagination si nécessaire
        Paginator::useBootstrapFive();
    }
}