<?php

namespace App\Policies;

use App\Models\SuccessStory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuccessStoryPolicy
{
    /**
     * Determine whether the user can work with success stories.
     */
    public function workWithSuccessStories(User $user): bool
    {
	    return $user->is_admin;
    }

}
