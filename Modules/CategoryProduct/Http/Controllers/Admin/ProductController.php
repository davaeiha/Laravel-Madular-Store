<?php

namespace Modules\CategoryProduct\Http\Controllers\Admin;


use App\Models\Attribute;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Modules\CategoryProduct\Entities\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-products")->only(['index']);
        $this->middleware("can:create-product")->only(['create','store']);
        $this->middleware("can:edit-product")->only(['edit','update']);
        $this->middleware("can:delete-product")->only(['destroy']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if($keyword = \request("search")){

            $products = Product::where("name","LIKE","%{$keyword}%")
                ->orWhere("label","LIKE","%{$keyword}%")
                ->latest()
                ->paginate(20);
        }else{
            $products = Product::latest()->paginate(20);
        }

        return view("categoryproduct::admin.products.all",["products"=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Product $product)
    {
        return view("categoryproduct::admin.products.create",['product'=>$product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title"=>["required","string","unique:products"],
            "description"=>["required"],
            "price"=>["required","integer"],
            "inventory"=>["required","integer"],
            "category"=>["required","array"],
            "image"=>['required'],
            "attributes"=>["array"]

        ]);


        $product = Product::create([
            "title"=>$validatedData['title'],
            "description"=>$validatedData["description"],
            "price"=>$validatedData["price"],
            "inventory"=>$validatedData["inventory"],
            "image"=>$validatedData["image"],
            "user_id"=>$request->user()->id,
        ]);

        $attributeCollection = collect($validatedData["attributes"]);

        $attributeCollection->each(function($item) use ($product) {

            $attr = Attribute::firstOrCreate(
                ["name"=>$item["name"]]
            );

            $attrValue = $attr->values()->firstOrCreate(
                ["value"=>$item["value"]]
            );

            $product->attributes()->detach($attr->id);
            $product->attributes()->attach($attr->id,["value_id"=>$attrValue->id]);
        });

        $product->categories()->sync($validatedData["category"]);

        alert()->success("محصول مورد نظر با موفقیت ایجاد شد")->closeOnClickOutside();
        return redirect(route("admin.products.index"));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {
        return view("categoryproduct::admin.products.edit",["product"=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            "title"=>["required","string",Rule::unique('products')->ignore($product->id)],
            "description"=>["required"],
            "price"=>["required","integer"],
            "inventory"=>["required","integer"],
            "category"=>["required","array"],
            "image"=>["required"]
        ]);

        $product->update($validatedData);

        $product->categories()->sync($validatedData["category"]);

        alert()->success("محصول مورد نظر با موفقیت ویرایش شد")->closeOnClickOutside();

        return redirect(route("admin.products.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        alert()->success("محصول مورد نظر با موفقیت حذف گردید")->closeOnClickOutside();
        return back();
    }


}
