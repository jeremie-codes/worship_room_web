<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\CotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DemandeFournitureController;
use App\Http\Controllers\CharroiController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\VisiteurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/password.request', function () {
    return view('auth.forgot-password');
})->name('password.request');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes des présences
    Route::resource('presences', PresenceController::class);
    Route::get('presences/search', [PresenceController::class, 'search'])->name('presences.search');

    // Routes des utilisateurs (remplace agents)
    Route::resource('users', UserController::class);

    // Routes des congés
    Route::resource('conges', CongeController::class);
    Route::post('conges/{conge}/approuver-directeur', [CongeController::class, 'approuverDirecteur'])->name('conges.approuver.directeur');
    Route::post('conges/{conge}/traiter-rh', [CongeController::class, 'traiterRH'])->name('conges.traiter.rh');
    Route::post('conges/{conge}/valider-drh', [CongeController::class, 'validerDRH'])->name('conges.valider.drh');
    Route::post('conges/{conge}/refuser', [CongeController::class, 'refuser'])->name('conges.refuser');

    // Routes des missions
    Route::resource('missions', MissionController::class);
    Route::post('missions/{mission}/demarrer', [MissionController::class, 'demarrer'])->name('missions.demarrer');
    Route::post('missions/{mission}/terminer', [MissionController::class, 'terminer'])->name('missions.terminer');
    Route::post('missions/{mission}/annuler', [MissionController::class, 'annuler'])->name('missions.annuler');

    // Routes des cotations
    Route::resource('cotations', CotationController::class);
    Route::post('cotations/{cotation}/valider', [CotationController::class, 'valider'])->name('cotations.valider');
    Route::post('cotations/{cotation}/refuser', [CotationController::class, 'refuser'])->name('cotations.refuser');

    // Routes de la logistique
    Route::resource('articles', ArticleController::class);
    Route::resource('demandes', DemandeFournitureController::class);
    Route::post('demandes/{demande}/approuver', [DemandeFournitureController::class, 'approuver'])->name('demandes.approuver');
    Route::post('demandes/{demande}/refuser', [DemandeFournitureController::class, 'refuser'])->name('demandes.refuser');
    Route::post('demandes/{demande}/livrer', [DemandeFournitureController::class, 'livrer'])->name('demandes.livrer');

    // Routes du charroi automobile
    Route::prefix('charroi')->name('charroi.')->group(function () {
        // Gestion des missions
        Route::get('/', [CharroiController::class, 'index'])->name('index');
        Route::get('/create', [CharroiController::class, 'create'])->name('create');
        Route::post('/', [CharroiController::class, 'store'])->name('store');
        Route::get('/{mission}', [CharroiController::class, 'show'])->name('show');
        Route::post('/{mission}/approuver', [CharroiController::class, 'approuver'])->name('approuver');
        Route::post('/{mission}/demarrer', [CharroiController::class, 'demarrer'])->name('demarrer');
        Route::post('/{mission}/terminer', [CharroiController::class, 'terminer'])->name('terminer');
        Route::post('/{mission}/annuler', [CharroiController::class, 'annuler'])->name('annuler');

        // Gestion des véhicules
        Route::resource('vehicules', VehiculeController::class);

        // Gestion des chauffeurs
        Route::resource('chauffeurs', ChauffeurController::class);
    });

    // Routes des paiements
    Route::resource('paiements', PaiementController::class);
    Route::post('paiements/{paiement}/valider', [PaiementController::class, 'valider'])->name('paiements.valider');
    Route::post('paiements/{paiement}/payer', [PaiementController::class, 'payer'])->name('paiements.payer');
    Route::post('paiements/{paiement}/annuler', [PaiementController::class, 'annuler'])->name('paiements.annuler');
    Route::get('paiements/{paiement}/bulletin', [PaiementController::class, 'bulletinPaie'])->name('paiements.bulletin');
    Route::post('paiements/generer-masse', [PaiementController::class, 'genererPaiementsMasse'])->name('paiements.generer-masse');

    // Routes des courriers
    Route::resource('courriers', CourrierController::class);
    Route::get('courriers-tableau-bord', [CourrierController::class, 'tableau_bord'])->name('courriers.tableau_bord');
    Route::get('courriers-recherche', [CourrierController::class, 'recherche'])->name('courriers.recherche');
    Route::post('courriers/{courrier}/changer-status', [CourrierController::class, 'changerStatus'])->name('courriers.changer-status');
    Route::post('courriers/{courrier}/transmettre', [CourrierController::class, 'transmettre'])->name('courriers.transmettre');
    Route::post('courriers/{courrier}/documents', [CourrierController::class, 'ajouterDocument'])->name('courriers.documents.ajouter');
    Route::get('documents/{document}/telecharger', [CourrierController::class, 'telechargerDocument'])->name('courriers.documents.telecharger');
    Route::delete('documents/{document}', [CourrierController::class, 'supprimerDocument'])->name('courriers.documents.supprimer');

    // Routes des visiteurs
    Route::resource('visiteurs', VisiteurController::class);
    Route::post('visiteurs/{visiteur}/marquer-sortie', [VisiteurController::class, 'marquerSortie'])->name('visiteurs.marquer-sortie');
    Route::get('visiteurs-recherche', [VisiteurController::class, 'recherche'])->name('visiteurs.recherche');
    Route::get('visiteurs-rapport', [VisiteurController::class, 'rapport'])->name('visiteurs.rapport');
    Route::get('visiteurs/{visiteur}/badge', [VisiteurController::class, 'badge'])->name('visiteurs.badge');

    // Routes d'administration
    // Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Gestion des rôles
    Route::resource('roles', RoleController::class);

    // Gestion des services
    Route::resource('services', ServiceController::class);
    // });
});
