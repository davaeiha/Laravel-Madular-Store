<?php

namespace Modules\Gallery\Http\Controllers\admin;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Modules\CategoryProduct\Entities\Product;
use Modules\Gallery\Entities\ProductGallery;

class ProductGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-gallery")->only(['index']);
        $this->middleware("can:create-gallery")->only(['create','store']);
        $this->middleware("can:edit-gallery")->only(['edit','update']);
        $this->middleware("can:delete-gallery")->only(['destroy']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Product $product)
    {
        $images = $product->images()->latest()->paginate(10);
        return \view("gallery::admin.all",compact(['product','images']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Product $product)
    {
        return \view("gallery::admin.create",compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request,Product $product)
    {
        $request->validate([
           'images.*.url'=>['required'],
           'images.*.alt'=>['required','string','max:30']
        ]);

        $imageCollection = collect($request->images);

        $imageCollection->each(function ($item) use ($product) {
            $product->images()->create([
                'image'=>$item['url'],
                'alt'=>$item['alt']
            ]);
        });

        alert()->success("گالری مورد نظر با موفقیت ایجاد شد");

        return redirect(route("admin.product.gallery.index",compact('product')));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param ProductGallery $gallery
     * @return Application|Factory|View
     */
    public function edit(Product $product,ProductGallery $gallery)
    {
        return \view("gallery::admin.edit",compact(['product','gallery']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param ProductGallery $gallery
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Product $product,ProductGallery $gallery)
    {
        $request->validate([
            'image'=>['required'],
            'alt'=>['required','string','max:30']
        ]);

        $gallery->update([
            'image'=>$request->image,
            'alt'=>$request->alt
        ]);


        alert()->success("تصویر مورد نظر با موفقیت ویرایش شد");
        return redirect(route("admin.product.gallery.index",compact('product')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductGallery $gallery
     * @return RedirectResponse
     */
    public function destroy(Product $product,ProductGallery $gallery): RedirectResponse
    {
        $gallery->delete();
        alert()->success("تصویر مورد نظر با موفقیت حذف شد");
        return back();
    }
}
