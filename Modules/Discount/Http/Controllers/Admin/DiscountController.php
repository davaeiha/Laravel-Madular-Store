<?php

namespace Modules\Discount\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\User;
use Artesaos\SEOTools\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-discounts")->only(['index']);
        $this->middleware("can:create-discount")->only(['create','store']);
        $this->middleware("can:edit-discount")->only(['edit','update']);
        $this->middleware("can:delete-discount")->only(['destroy']);

    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {

        if($keyword = \request('search')){
            $discounts = Discount::where('occasion',"%{$keyword}%")
                ->orWhere('user',"%{$keyword}%")
                ->orWhere('expired_at',"%{$keyword}%")
                ->latest()
                ->paginate(10);
        }else{
            $discounts = Discount::latest()->paginate(10);
        }


        return view('discount::admin.all',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('discount::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            "occasion" => ['required', 'string', 'max:30'],
            "code" => ['required', 'unique:discounts', "string", 'max:8'],
            "percent" => ["required", "numeric", 'between:0,100'],
            "user" => ["required", 'string', Rule::in(['all', 'low', 'middle', 'high'])],
            "expired_at" => ['date'],
            'category' => ['array', Rule::requiredIf(is_null($request->product)), 'exists:categories,id'],
            'product' => ['array', Rule::requiredIf(is_null($request->category)), 'exists:products,id']
        ]);

        $discount = Discount::create([
            'occasion'=>$validatedData['occasion'],
            'code'=>$validatedData['code'],
            'percent'=>$validatedData['percent'],
            'expired_at'=>$validatedData['expired_at'],
        ]);

        $discount->users()->detach();

        $this->attachUser($request, $discount);

        if(!is_null($request->category)){
            $discount->categories()->sync($validatedData['category']);
            collect($validatedData['category'])->each(function ($categoryId) use ($discount) {
                $category = Category::findOrFail($categoryId);
                $products=$category->products;
                $discount->products()->detach();
                $products->each(function($product) use ($discount) {
                    $discount->products()->sync($product->id);
                });
            });
        }

        if (!is_null($request->product)){
            $discount->products()->sync($validatedData['product']);
        }

        alert()->success("تخفیف مورد نظر با موفقیت ایجاد شد");
        return redirect(route('admin.discounts.index'));

    }

//    /**
//     * Show the specified resource.
//     * @param images $discount
//     * @return Renderable
//     */
//    public function show(images $discount): Renderable
//    {
//        return view('discount::admin.details',compact('discount'));
//    }

    /**
     * Show the form for editing the specified resource.
     * @param Discount $discount
     * @return Renderable
     */
    public function edit(Discount $discount): Renderable
    {
        return view('discount::admin.edit',compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Discount $discount
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, Discount $discount)
    {
        $validatedData = $request->validate([
            "occasion" => ['required', 'string', 'max:30'],
            "code" => ['required', Rule::unique('discounts')->ignore($discount->id), "string", 'max:6'],
            "percent" => ["required", "numeric", 'between:0,100'],
            "user" => ["required", 'string', Rule::in(['all', 'low', 'middle', 'high'])],
            "expired_at" => ['date'],
            'category' => ['array', Rule::requiredIf(is_null($request->product)),'exists:categories,id'],
            'product' => ['array',Rule::requiredIf(is_null($request->category)),'exists:products,id']
        ]);

        $discount->update([
            'occasion'=>$validatedData['occasion'],
            'code'=>$validatedData['code'],
            'percent'=>$validatedData['percent'],
            'expired_at'=>$validatedData['expired_at'],
        ]);

        $this->attachUser($request, $discount);

        if(!is_null($request->category)){
            $discount->categories()->sync($validatedData['category']);

            collect($validatedData['category'])->each(function ($categoryId) use ($discount) {
                $category = Category::findOrFail($categoryId);
                $products=$category->products;
                $products->each(function($product) use ($discount) {
                    $discount->products()->attach($product->id);
                });
            });

        }

        if (!is_null($request->product)){
            $discount->products()->sync($validatedData['product']);
        }

        alert()->success("تخفیف مورد نظر با موفقیت ویرایش شد");
        return redirect(route("admin.discounts.index"));

    }

    /**
     * Remove the specified resource from storage.
     * @param Discount $discount
     * @return RedirectResponse
     */
    public function destroy(Discount $discount): RedirectResponse
    {
        $discount->delete();
        alert()->success("تخفیف مورد نظر با موفقیت حذف شد");
        return back();
    }

    /**
     * @param Request $request
     * @param Discount $discount
     */
    public function attachUser(Request $request, Discount $discount): void
    {
        if ($request->user == 'all') {
            $discount->users()->sync(User::all()->pluck('id')->toArray());
        } elseif ($request->user == 'low') {
            $discount->users()->sync(User::whereBetween('UX_rank', [0, 100])->pluck('id')->toArray());
        } elseif ($request->user == 'middle') {
            $discount->users()->sync(User::whereBetween('UX_rank', [101, 200])->pluck('id')->toArray());
        } else {
            $discount->users()->sync(User::where('UX_rank', '>=', 201)->pluck('id')->toArray());
        }
    }
}
