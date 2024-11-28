<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
			//
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pet $pet): bool
    {
			//
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pet $pet): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pet $pet): bool
    {
	    return $user->id === $pet->user_id || $user->id === 21; // admin or user who created this pet
	    //return $user->id === 21; // only andrei (admin) can delete
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
