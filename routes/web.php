<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogistiqueController;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Employés
    Route::resource('employes', EmployeController::class);

    // Congés
    Route::resource('conges', CongeController::class);
    Route::post('conges/{conge}/approve', [CongeController::class, 'approve'])->name('conges.approve');
    Route::post('conges/{conge}/reject', [CongeController::class, 'reject'])->name('conges.reject');

    // Présences
    Route::resource('presences', PresenceController::class);

    // Utilisateurs et Rôles
    Route::get('users/roles', [UserController::class, 'roles'])->name('users.roles');
    Route::post('users/roles', [UserController::class, 'storeRole'])->name('users.roles.store');
    Route::put('users/roles/{role}', [UserController::class, 'updateRole'])->name('users.roles.update');
    Route::resource('users', UserController::class);

    // Logistique
    Route::resource('logistique', LogistiqueController::class);
    Route::post('logistique/demande', [LogistiqueController::class, 'storeDemande'])->name('logistique.demande.store');
    Route::put('logistique/produit/{produit}', [LogistiqueController::class, 'updateProduit'])->name('logistique.produit.update');
});
