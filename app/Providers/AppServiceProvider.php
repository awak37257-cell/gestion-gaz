<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\DemandeApprovisionnement; // Assurez-vous que le nom de votre modèle correspond bien

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
        Schema::defaultStringLength(191);

        // Partager le compteur des demandes en attente avec le layout admin
        View::composer('layouts.admin', function ($view) {
            $demandesEnAttenteCount = DemandeApprovisionnement::where('statut', 'en_attente')->count();
            $view->with('demandesEnAttenteCount', $demandesEnAttenteCount);
        });
    }
}