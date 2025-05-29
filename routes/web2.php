<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\SupplyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes d'authentification
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    // Tableau de bord
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des employés (accès limité aux RH)
    Route::resource('employees', EmployeeController::class);
    // Route::middleware('can:manage-employees')->group(function () {
    // });

    // Gestion des congés
    Route::get('leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::get('leaves/create', [LeaveRequestController::class, 'create'])->name('leaves.create');
    Route::post('leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
    Route::get('leaves/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leaves.show');
    Route::patch('leaves/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])
        ->name('leaves.updateStatus')
        ->middleware('can:updateStatus,leaveRequest');

    // Gestion des présences
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store')
        ->middleware('can:manage-attendance');

    // Gestion des fournitures
    Route::prefix('supplies')->name('supplies.')->group(function () {
        // Demandes de fournitures
        Route::get('requests', [SupplyController::class, 'index'])->name('requests.index');
        Route::get('requests/create', [SupplyController::class, 'create'])->name('requests.create');
        Route::post('requests', [SupplyController::class, 'store'])->name('requests.store');
        Route::patch('requests/{supplyRequest}/status', [SupplyController::class, 'updateStatus'])
            ->name('requests.updateStatus')
            ->middleware('can:updateStatus,supplyRequest');

        // Gestion du stock (accès limité aux RH)
        Route::middleware('can:manage-stock')->group(function () {
            Route::get('stock', [SupplyController::class, 'stockIndex'])->name('stock.index');
            Route::get('stock/create', [SupplyController::class, 'stockCreate'])->name('stock.create');
            Route::post('stock', [SupplyController::class, 'stockStore'])->name('stock.store');
            Route::get('stock/{stockItem}/edit', [SupplyController::class, 'stockEdit'])->name('stock.edit');
            Route::put('stock/{stockItem}', [SupplyController::class, 'stockUpdate'])->name('stock.update');
        });
    });
});
