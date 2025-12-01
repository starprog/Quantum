<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChildPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own children list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Child $child): bool
    {
        // User is the child's parent
        if ($child->user_id === $user->id) {
            return true;
        }

        // User is a caregiver with access
        return $child->caregivers()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create a child profile
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Child $child): bool
    {
        // User is the child's parent
        if ($child->user_id === $user->id) {
            return true;
        }

        // User is a caregiver with edit permissions
        return $child->caregivers()
            ->where('user_id', $user->id)
            ->where('can_edit', true)
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Child $child): bool
    {
        // Only the child's primary parent can delete
        return $child->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Child $child): bool
    {
        // Only the child's primary parent can restore
        return $child->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Child $child): bool
    {
        // Only the child's primary parent can permanently delete
        return $child->user_id === $user->id;
    }
}