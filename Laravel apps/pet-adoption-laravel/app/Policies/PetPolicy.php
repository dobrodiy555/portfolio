<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pet $pet): bool
    {
	    return $user->id === $pet->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pet $pet): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pet $pet): bool
    {
        //
    }
}
