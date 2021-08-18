<?php

namespace Modules\CategoryProduct\Http\Controllers\Admin;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Modules\CategoryProduct\Entities\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $search = request("search");
        if(!is_null($search)){
            $categories = Category::where("name","like","%{$search}%")->where("parent_id",0)->latest()->paginate(10);
        }else{
            $categories = Category::where("parent_id",0)->latest()->paginate(10);
        }
        return view("categoryproduct::admin.categories.all",["categories"=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $categories = Category::all();

        if (\request("parent"))
        {
            $request->session()->flash("parent",$request->parent);
        }

        return \view("categoryproduct::admin.categories.create",["categories"=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        $parent_id = $request->session()->get("parent") ?? 0;

        $validatedData = $request->validate([
            "name"=>"required",
        ]);

        Category::create([
            "name"=>$validatedData["name"],
            "parent_id"=> $parent_id,
        ]);

        alert()->success("دسته بندی مورد نظر با موفقیت ثبت شد")->closeOnClickOutside();
        return redirect(route('admin.categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        return \view('categoryproduct::admin.categories.edit',compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            "name"=>"required"
        ]);

        $category->update([
            "name"=>$validatedData["name"]
        ]);

        alert()->success("دسته بندی مورد نظر ویرایش شد");

        return redirect(route("admin.categories.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        alert()->success("دسته بندی مورد نظر با موفقیت حذف شد")->closeOnClickOutside();
        return back();
    }
}
