<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware("can:staff-user-permission")->only(["create","store"]);
    }

    public function create(User $user){
        return view("admin.users.permissions",["user"=>$user]);
    }

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
