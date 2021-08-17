<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Permission;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        return view("admin.products.all",["products"=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Product $product)
    {
        return view("admin.products.create",['product'=>$product]);
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
            "image"=>['image','max:500'],
            "attributes"=>["array"]

        ]);

        $file = $request->file('image');
//        $direction = '/images/'.jdate()->getYear().'/'.jdate()->getMonth().'/'.jdate()->getDay();
//        $file->move(public_path($this->direction()),$file->getClientOriginalName());
            $this->moveFile($file);
//        $this->moveFile($request,'image',$this->direction());

        $validatedData['image'] = $this->direction().'/'.$file->getClientOriginalName();


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
        return view("admin.products.edit",["product"=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Product $product)
    {

        Storage::disk('public')->putFileAs('files',$request->file('test'),$request->file('test')->getClientOriginalName());
//        Storage::disk('public')->delete('files\\'.$request->file('test')->getClientOriginalName());
//        Storage::disk('public')->download('files\\'.$request->file('test')->getClientOriginalName());
//        $content = Storage::disk('public')->get('files\\'.$request->file('test')->getClientOriginalName());
        $url = Storage::disk('public')->url('files/'.$request->file('test')->getClientOriginalName());
        dd($url);
        return 'ok';


        $validatedData = $request->validate([
            "title"=>["required","string",Rule::unique('products')->ignore($product->id)],
            "description"=>["required"],
            "price"=>["required","integer"],
            "inventory"=>["required","integer"],
            "category"=>["required","array"],
            "image"=>["required"]
        ]);

//        if($file = $request->file("image")){
////            $validatedData['image'] = Validator::make([$request->image],['image'=>'image','max:500']);
//            $request->validate([
//                "image"=>["image","max:500"]
//            ]);
//
//            if(File::exists(public_path($product->image))){
//                File::delete(public_path($product->image));
//            }
//            $validatedData["image"] = $this->direction().'/'.$file->getClientOriginalName();
//
//            $this->moveFile($file);
//
//        }

        $product->update($validatedData);



//        $product->update([
//            "title"=>$validatedData['title'],
//            "description"=>$validatedData["description"],
//            "price"=>$validatedData["price"],
//            "inventory"=>$validatedData["inventory"],
//            "user_id"=>$request->user()->id,
//        ]);



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
        return back();
    }

//    protected function moveFile(Request $request,$key,$direction){
//        $file = $request->file($key);
//
//        $file->move(public_path($direction),$file->getClientOriginalName());
//
//    }
//
    protected function direction(): string
    {
        return '/images/'.jdate()->getYear().'/'.jdate()->getMonth().'/'.jdate()->getDay();
    }
    protected function moveFile($file){
        $file->move(public_path($this->direction()),$file->getClientOriginalName());
    }
}
