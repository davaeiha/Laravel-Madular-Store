<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user,$currentUser){
        return $user->id == $currentUser->id;
    }

    public function delete(User $user,$currentUser){
        return $user->id == $currentUser->id;
    }

//    public function edit(User $user){
//        foreach ()
//    }

}
