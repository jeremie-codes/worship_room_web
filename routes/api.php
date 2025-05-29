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
| API Routes
|--------------------------------------------------------------------------
*/

// Route d'authentification API
Route::post('login', [AuthController::class, 'apiLogin']);

// Routes protégées par sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Tableau de bord
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    
    // Employés
    Route::get('employees', [EmployeeController::class, 'apiIndex']);
    Route::get('employees/{employee}', [EmployeeController::class, 'apiShow']);
    Route::post('employees', [EmployeeController::class, 'apiStore'])
        ->middleware('can:manage-employees');
    
    // Congés
    Route::get('leaves', [LeaveRequestController::class, 'apiIndex']);
    Route::post('leaves', [LeaveRequestController::class, 'apiStore']);
    Route::patch('leaves/{leaveRequest}/status', [LeaveRequestController::class, 'apiUpdateStatus']);
    
    // Présences
    Route::get('attendance/today', [AttendanceController::class, 'apiTodayAttendance']);
    Route::post('attendance', [AttendanceController::class, 'apiMarkAttendance'])
        ->middleware('can:manage-attendance');
    
    // Fournitures
    Route::get('supplies/requests', [SupplyController::class, 'apiRequests']);
    Route::post('supplies/requests', [SupplyController::class, 'apiCreateRequest']);
    Route::patch('supplies/requests/{supplyRequest}/status', [SupplyController::class, 'apiUpdateStatus'])
        ->middleware('can:updateStatus,supplyRequest');
    
    Route::get('supplies/stock', [SupplyController::class, 'apiStockItems']);
});