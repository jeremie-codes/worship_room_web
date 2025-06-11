<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\BroadcasterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/streams', [StreamController::class, 'index'])->name('streams.index');
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/streams/{stream}', [StreamController::class, 'show'])->name('streams.show');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.delete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');

    // Subscriptions
    Route::post('/subscribe/{broadcaster}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::delete('/unsubscribe/{broadcaster}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('/my-subscriptions', [SubscriptionController::class, 'mySubscriptions'])->name('subscriptions.index');

    // Donations
    Route::get('/donate', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donation-history', [DonationController::class, 'history'])->name('donations.history');

    // Interactions
    Route::post('/streams/{stream}/like', [StreamController::class, 'like'])->name('streams.like');
    Route::post('/streams/{stream}/comment', [StreamController::class, 'comment'])->name('streams.comment');
    Route::post('/videos/{video}/like', [VideoController::class, 'like'])->name('videos.like');
    Route::post('/videos/{video}/comment', [VideoController::class, 'comment'])->name('videos.comment');
});

// Broadcaster routes
Route::middleware(['auth', 'broadcaster'])->prefix('broadcaster')->name('broadcaster.')->group(function () {
    Route::get('/streams', [BroadcasterController::class, 'streams'])->name('streams');
    Route::get('/videos', [BroadcasterController::class, 'videos'])->name('videos');
    Route::get('/donations', [BroadcasterController::class, 'donations'])->name('donations');
    Route::get('/profile', [BroadcasterController::class, 'profile'])->name('profile');
    Route::put('/profile', [BroadcasterController::class, 'updateProfile'])->name('profile.update');
    Route::post('/deactivate', [BroadcasterController::class, 'deactivateAccount'])->name('deactivate');

    // Stream management
    Route::get('/streams/create', [StreamController::class, 'create'])->name('streams.create');
    Route::post('/streams', [StreamController::class, 'store'])->name('streams.store');
});
