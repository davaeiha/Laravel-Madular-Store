@component("admin.layout.content",["title"=>"فرم اطلاعات تخفیف"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">فرم اطلاعات تخفیف</li>
        </ol>
    @endslot

    <div class="card-header">
        <h3 class="card-title">اطلاعات تخفیف </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <div class="card-body">

        @php
            $categories =\Modules\CategoryProduct\Entities\Category::all();

            foreach($categories as $category){
                if ($category->child->isEmpty()){
                    $lastLevelCategory[] = $category;
                }
            }
        $products = \Modules\CategoryProduct\Entities\Product::all();
        @endphp

        <div class="list-group ">
            <label for="category"  class="col-sm-2 control-label">دسته بندی</label>
            <select name="category[]" id="category" class="form-control" multiple>
                @foreach($lastLevelCategory as $category )
                    <option value="{{$category->id}}" name="{{$category->name}}" {{$discount->categories->contains($category) ? "selected" : ""}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="product"  class="col-sm-2 control-label">محصولات</label>
            <select name="product[]" id="product" class="form-control" multiple>
                @foreach($products as $product )
                    <option value="{{$product->id}}" name="{{$product->title}}" {{$discount->products->contains($product) ? "selected" : ""}}>{{$product->title}}</option>
                @endforeach
            </select>
        </div>
    </div>


@endcomponent
