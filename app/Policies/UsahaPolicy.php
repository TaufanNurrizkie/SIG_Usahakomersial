<?php

namespace App\Policies;

use App\Models\Usaha;
use App\Models\User;

class UsahaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Usaha $usaha): bool
    {
        // Admin, operator, camat can view all
        if ($user->hasAnyRole(['admin', 'operator', 'camat'])) {
            return true;
        }

        // User can only view their own usaha
        return $user->id === $usaha->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-usaha');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Usaha $usaha): bool
    {
        // Admin can update any
        if ($user->hasRole('admin')) {
            return true;
        }

        // User can only update their own usaha if status is 'menunggu' or 'ditolak'
        if ($user->id === $usaha->user_id) {
            return in_array($usaha->status, ['menunggu', 'ditolak']);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Usaha $usaha): bool
    {
        // Admin can delete any
        if ($user->hasRole('admin')) {
            return true;
        }

        // User can only delete their own usaha if status is 'menunggu' or 'ditolak'
        if ($user->id === $usaha->user_id) {
            return in_array($usaha->status, ['menunggu', 'ditolak']);
        }

        return false;
    }

    /**
     * Determine whether the user can approve (admin approval).
     */
    public function approve(User $user, Usaha $usaha): bool
    {
        return $user->hasAnyRole(['admin', 'operator']) && $usaha->status === 'menunggu';
    }

    /**
     * Determine whether the user can give final approval (camat).
     */
    public function finalApprove(User $user, Usaha $usaha): bool
    {
        return $user->hasRole('camat') && $usaha->status === 'menunggu';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Usaha $usaha): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Usaha $usaha): bool
    {
        return $user->hasRole('admin');
    }
}
