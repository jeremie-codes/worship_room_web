<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the leave request.
     */
    public function view(User $user, LeaveRequest $leaveRequest)
    {
        return $user->isRH() || $user->employee->id === $leaveRequest->employee_id;
    }

    /**
     * Determine whether the user can update the status of the leave request.
     */
    public function updateStatus(User $user, LeaveRequest $leaveRequest)
    {
        return $user->isRH();
    }
}