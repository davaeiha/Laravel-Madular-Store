<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-roles")->only(["index"]);
        $this->middleware("can:edit-role")->only(["edit","update"]);
        $this->middleware("can:create-role")->only(["create","store"]);
        $this->middleware("can:delete-role")->only(["destroy"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if($keyword = \request("search")){

            $roles = Role::where("name","LIKE","%{$keyword}%")
                ->orWhere("label","LIKE","%{$keyword}%")
                ->latest()
                ->paginate(20);
        }else{
            $roles = Role::latest()->paginate(20);
        }

        return view("admin.roles.all",["roles"=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = Permission::all();
        return view("admin.roles.create",["permissions"=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name"=>["required","string","unique:roles"],
            "label"=>["required","string"],
            "permissions"=>["required","array"]
        ]);



        $role = Role::create([
            "name"=>$validatedData["name"],
            "label"=>$validatedData["label"],
        ]);

        $role->permissions()->sync($validatedData["permissions"]);

//        foreach($request->permissions as $permissionId){
//            DB::table("permission_role")->insert([
//                "permission_id"=>$permissionId,
//                "role_id"=>$role->id
//            ]);
//        }

        alert()->success("دسترسی مورد نظر با موفقیت ایجاد شد")->closeOnClickOutside();
        return redirect(route("admin.roles.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return void
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {

        return view("admin.roles.edit",["role"=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            "name"=>["required","string",Rule::unique("roles")->ignore($role->id)],
            "label"=>["required","string"],
            "permissions"=>["required","array"]
        ]);

        $role->update([
            "name"=>$validatedData["name"],
            "label"=>$validatedData["label"],
        ]);

        $role->permissions()->sync($validatedData["permissions"]);

        alert()->success("مقام مورد نظر با موفقیت ویرایش شد")->closeOnClickOutside();

        return redirect(route("admin.roles.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        alert()->success("مقام مورد نظر با موفقیت ");
        return back();
    }
}
