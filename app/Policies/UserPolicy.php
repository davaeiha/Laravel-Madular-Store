<?php

namespace App\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

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

    public function edit(User $user,$currentUser): bool
    {
        return $user->id == $currentUser->id;
    }

    public function delete(User $user,$currentUser): bool
    {
        return $user->id == $currentUser->id;
    }

//    public function edit(User $user){
//        foreach ()
//    }

}
