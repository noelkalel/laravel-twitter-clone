<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $loggedUser, User $user)
    {
        // dd($loggedUser, $user);
        // return $loggedUser->id === $user->id;
        return $loggedUser->is($user);
    }
}
