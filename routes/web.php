<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandeApprovisionnementController;
use App\Http\Controllers\VendeurAccessController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\Admin\CouleurController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DemandeApprovisionnementController as AdminDemandeController;
use App\Http\Controllers\Admin\DepotController;
use App\Http\Controllers\ClientEspaceController;
use App\Http\Controllers\Admin\MarqueController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\VendeurController as AdminVendeurController;
use App\Http\Controllers\Admin\InventaireController as AdminInventaireController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DemandeAccesController;
use App\Http\Controllers\SuperAdmin\ClientController as SuperAdminClientController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\DemandeAccesController as SuperAdminDemandeAccesController;
use App\Http\Controllers\SuperAdmin\ImpersonationController;
use App\Http\Controllers\SuperAdmin\PaiementController as SuperAdminPaiementController;
use App\Http\Controllers\Admin\ParametreController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/demande-acces', [DemandeAccesController::class, 'store'])->name('demande-acces.store');

Route::middleware('client.actif')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
// Route pour l'espace personnalisé du client via son slug unique
Route::get('/espace/{client:slug}', [ClientEspaceController::class, 'show'])->name('client.espace');
    Route::resource('depots', DepotController::class)->except('show');
    Route::resource('marques', MarqueController::class)->except('show');
    Route::resource('couleurs', CouleurController::class)->except('show');
    Route::resource('vendeurs', AdminVendeurController::class);
    
    // Route unique et correcte pour consulter les ventes d'un dépôt
    Route::get('/ventes/depot/{depotId}', [AdminDashboardController::class, 'ventesParDepotJour'])->name('ventes.depot.jour');

    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::patch('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');

    Route::get('/demandes', [AdminDemandeController::class, 'index'])->name('demandes.index');
    Route::patch('/demandes/{demande}/valider', [AdminDemandeController::class, 'valider'])->name('demandes.valider');
    Route::patch('/demandes/{demande}/livrer', [AdminDemandeController::class, 'livrer'])->name('demandes.livrer');
    
    Route::get('/inventaires', [AdminInventaireController::class, 'index'])->name('inventaires.index');
    
    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::put('/parametres', [ParametreController::class, 'update'])->name('parametres.update');
});

Route::middleware(['auth', 'super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/paiements', [SuperAdminPaiementController::class, 'index'])->name('paiements.index');
   // Afficher le formulaire pour configurer le lien et envoyer
Route::get('/demandes/{demande}/lien', [SuperAdminDemandeAccesController::class, 'formulaireLien'])->name('demandes.formulaire-lien');

// Traiter le formulaire et envoyer l'e-mail
Route::post('/demandes/{demande}/envoyer-acces', [SuperAdminDemandeAccesController::class, 'envoyerAcces'])->name('demandes.envoyer-acces');
    // Gestion des demandes d'accès publiques
    Route::get('/demandes-acces', [SuperAdminDemandeAccesController::class, 'index'])->name('demandes.index');
    Route::post('/demandes-acces/{demande}/valider', [SuperAdminDemandeAccesController::class, 'valider'])->name('demandes.valider');
    Route::post('/demandes-acces/{demande}/rejeter', [SuperAdminDemandeAccesController::class, 'rejeter'])->name('demandes.rejeter');
    Route::delete('/demandes-acces/{demande}', [SuperAdminDemandeAccesController::class, 'destroy'])->name('demandes.destroy');
    Route::get('/demandes/{demande}/creer', [SuperAdminDemandeAccesController::class, 'create'])->name('super-admin.demandes.create');
    // Gestion des clients
    Route::get('/clients/export', [SuperAdminClientController::class, 'exporter'])->name('clients.exporter');
    Route::resource('clients', SuperAdminClientController::class);
    Route::patch('/clients/{client}/renouveler', [SuperAdminClientController::class, 'renouveler'])->name('clients.renouveler');
    Route::patch('/clients/{client}/basculer-statut', [SuperAdminClientController::class, 'basculerStatut'])->name('clients.basculer-statut');
    Route::post('/clients/{client}/reinitialiser-mot-de-passe', [SuperAdminClientController::class, 'reinitialiserMotDePasse'])->name('clients.reinitialiser-mot-de-passe');
    Route::post('/clients/{client}/paiements', [SuperAdminClientController::class, 'enregistrerPaiement'])->name('clients.paiements.store');
    Route::post('/clients/{client}/impersonner', [ImpersonationController::class, 'demarrer'])->name('clients.impersonner');
});

Route::post('/impersonation/quitter', [ImpersonationController::class, 'quitter'])
    ->name('impersonation.quitter')
    ->middleware('auth');
// Accès via QR code personnel du vendeur
Route::get('/vendeur/scan/{tokenQr}', [VendeurAccessController::class, 'scan'])->name('vendeur.scan');

Route::middleware('vendeur.connecte')->prefix('vendeur')->name('vendeur.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/deconnexion', [VendeurAccessController::class, 'deconnexion'])->name('deconnexion');
    Route::get('/ventes', [VenteController::class, 'index'])->name('ventes.index');
    Route::get('/ventes/creer', [VenteController::class, 'create'])->name('ventes.create');
    Route::post('/ventes', [VenteController::class, 'store'])->name('ventes.store');

    Route::get('/demandes/creer', [DemandeApprovisionnementController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeApprovisionnementController::class, 'store'])->name('demandes.store');
Route::get('/ventes/{vente}/recu', [VenteController::class, 'recu'])->name('ventes.recu');

Route::get('/inventaires/creer', [InventaireController::class, 'create'])->name('inventaires.create');
Route::post('/inventaires', [InventaireController::class, 'store'])->name('inventaires.store');
Route::get('/inventaires/{inventaire}', [InventaireController::class, 'show'])->name('inventaires.show');

    });
    // Afficher le formulaire de connexion (GET)
Route::get('/presentation', function () {
    return view('presentation');
})->name('presentation');

Route::get('/login', [LoginController::class, 'create'])->name('login');

// Traiter la connexion (POST)
Route::post('/login', [LoginController::class, 'store']);

// Déconnexion (POST ou GET selon ton implémentation, POST est recommandé)
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/espace/{client:slug}', [ClientEspaceController::class, 'show'])->name('client.espace');