<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * specifying the permissions for each method
     */
    public function __construct()
    {
        $this->middleware("can:edit-user")->only(["edit","update"]);
        $this->middleware("can:create-user")->only(["create","store"]);
        $this->middleware("can:delete-user")->only(["destroy"]);
        $this->middleware("can:show-user")->only(["index"]);

    }

    /**
     * Display a listing of the resource.
     * show all the users
     * @return Application|Factory|View
     */
    public function index()
    {

        if($keyword = \request("search")){

            $users = User::where("email","LIKE","%{$keyword}%")
                            ->orWhere("name","LIKE","%{$keyword}%")
                            ->orWhere("id",$keyword)
                            ->latest()
                            ->paginate(20);
        }else{
            $users = User::latest()->paginate(20);
        }


        if (Gate::allows("show-staff-users")) {
            if(\request("admin")) {
                $users = User::where("is_supervisor", 1)->orWhere("is_staff", 1)->paginate(20);
            }
        }else{
            $users = User::where("is_supervisor", 0)->orWhere("is_staff", 0)->paginate(20);
        }

        return view("admin.users.all",["users"=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view("admin.users.create");
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            "name"=>$validatedData["name"],
            "email"=>$validatedData["email"],
            "password"=>Hash::make($validatedData["password"])
        ]);

        if($request->has("verify")){
            $user->markEmailAsVerified();
        }

        return redirect(route("admin.users.index"));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view("admin.users.edit",compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique("users")->ignore($user->id)],
        ]);

        if(!is_null($request->input("password"))){
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $validatedData["password"] = $request->password;
        }

        $user->update($validatedData);

        if($request->has("verify")){
            $user->markEmailAsVerified();
        }

        return redirect(route("admin.users.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return back();
    }
}
