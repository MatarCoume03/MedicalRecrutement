<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
    public function boot()
{

    \URL::forceScheme('https'); // Si vous utilisez HTTPS
    \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    
    // Désactive CSRF complètement (pour développement seulement)
    \App\Http\Middleware\VerifyCsrfToken::except(['*']);

    // Enregistrement correct du composant
    Blade::component('icons.user', \App\View\Components\Icons\User::class);
    
    // OU pour enregistrer tous les composants du dossier Icons :
    Blade::componentNamespace('App\\View\\Components\\Icons', 'icons');
}
}
