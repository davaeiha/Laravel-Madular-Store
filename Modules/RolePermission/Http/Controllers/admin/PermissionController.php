<?php

namespace Modules\RolePermission\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Modules\RolePermission\Entities\Permission;

class PermissionController extends Controller
{
    /**
     * specifying Gates
     */
    public function __construct()
    {
        $this->middleware("can:show-permissions")->only(["index"]);
        $this->middleware("can:edit-permission")->only(["edit","update"]);
        $this->middleware("can:create-permission")->only(["create","store"]);
        $this->middleware("can:delete-permission")->only(["destroy"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return ApplicationAlias|Factory|View
     */
    public function index()
    {
        if($keyword = \request("search")){

            $permissions = Permission::where("name","LIKE","%{$keyword}%")
                ->orWhere("label","LIKE","%{$keyword}%")
                ->latest()
                ->paginate(20);
        }else{
            $permissions = Permission::latest()->paginate(20);
        }

        return view("rolepermission::admin.permissions.all",["permissions"=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ApplicationAlias|Factory|View
     */
    public function create()
    {
        return view("rolepermission::admin.permissions.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ApplicationAlias|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name"=>["required","string","unique:permissions"],
            "label"=>["required","string"]
        ]);
        Permission::create($validatedData);
        alert()->success("دسترسی مورد نظر با موفقیت ایجاد شد")->closeOnClickOutside();
        return redirect(route("admin.permission.index"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return ApplicationAlias|Factory|View
     */
    public function edit(Permission $permission)
    {
        return view("rolepermission::admin.permissions.edit",["permission"=>$permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Permission $permission
     * @return ApplicationAlias|RedirectResponse|Redirector
     */
    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            "name"=>["required","string","unique:permissions"],
            "label"=>["required","string"]
        ]);

        $permission->update($validatedData);

        alert()->success("دسترسی مورد نظر با موفقیت ویرایش شد")->closeOnClickOutside();

        return redirect(route("admin.permission.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        alert()->success("دسترسی مورد نظر با موفقیت حذف گردید")->closeOnClickOutside();
        return back();
    }
}
