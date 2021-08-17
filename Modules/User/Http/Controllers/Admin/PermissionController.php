<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;

class PermissionController extends Controller
{
    /**
     * specifying the permission
     */
    public function __construct(){
        $this->middleware("can:staff-user-permission")->only(["create","store"]);
    }

    /**
     * go to page for making a permission for user
     * @param User $user
     * @return Application|Factory|View
     */
    public function create(User $user){
        return view("user::admin.permissions",["user"=>$user]);
    }

    /**
     * storing a specific permission for user
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request,User $user){
        $validatedData = $request->validate([
            "permissions"=>['array'],
            "roles"=>["required",'array']
        ]);

        $user->roles()->sync($validatedData["roles"]);
        $user->permissions()->detach();

        foreach($validatedData['roles'] as $roleId){
            $roleCollection = Role::where("id",$roleId)->get();

            $roleCollection->each(function ($role) use ($user) {
                $permissionCollection = $role->permissions;
                $permissionCollection->each(function ($permission) use ($user) {
                    $user->permissions()->attach($permission->id);
                });
            });
        }


        if(!is_null($request->input("permissions")) || !is_null($request->input("roles"))){
            $user->update([
                "is_staff"=>1,
            ]);
        }

        alert()->success("کاربر مورد نظر به مقام مورد نظر ارتقا یافت")->closeOnClickOutside();
        return redirect(route("admin.users.index"));

    }
}
