<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Permission;
use App\Models\User;
use App\Policies\OrderPlicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
//        User::class => UserPolicy::class,
        Order::class =>OrderPlicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /*Gate way*/
//        Gate::define("edit-user",function( $user,$currentUser){
//            return $user->id == $currentUser->id;
//        });
//        $users = User::all();
//        foreach ($users as $user){
//            foreach ($user->permissions()->pluck("name") as $name){
//                Gate::define($name,function ($userr,$currentUser){
//                    return $userr->id == $currentUser->id;
//                });
//            }
//        }

        Gate::before(function($user){
            if($user->is_supervisor()){
                return true;
            }
        });

        foreach(Permission::all() as $permission){
            Gate::define($permission->name,function ($user) use ($permission) {
//                return !! $user->hasPermission($permission) || $user->hasRoleByPermission($permission);
                return $user->userAllowed($permission);
            });
        }

    }
}
