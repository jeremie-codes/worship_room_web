<?php

namespace App\Policies;

use App\Models\SupplyRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplyRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the supply request.
     */
    public function view(User $user, SupplyRequest $supplyRequest)
    {
        return $user->isRH() || $user->employee->id === $supplyRequest->employee_id;
    }

    /**
     * Determine whether the user can update the status of the supply request.
     */
    public function updateStatus(User $user, SupplyRequest $supplyRequest)
    {
        return $user->isRH();
    }
}