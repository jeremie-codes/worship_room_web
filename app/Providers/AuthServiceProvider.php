<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Models\SupplyRequest;
use App\Policies\LeaveRequestPolicy;
use App\Policies\SupplyRequestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        LeaveRequest::class => LeaveRequestPolicy::class,
        SupplyRequest::class => SupplyRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Définir les gates pour les autorisations
        Gate::define('manage-employees', function ($user) {
            return $user->isRH();
        });

        Gate::define('manage-attendance', function ($user) {
            return $user->isRH();
        });

        Gate::define('manage-stock', function ($user) {
            return $user->isRH();
        });

        Gate::define('approve-leaves', function ($user) {
            return $user->isRH();
        });

        Gate::define('approve-supplies', function ($user) {
            return $user->isRH();
        });
    }
}