@component("admin.layout.content",["title"=>"فرم ایجاد تخفیف"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">فرم ایجاد تخفیف</li>
        </ol>
    @endslot

    <div class="card-header">
        <h3 class="card-title">ایجاد تخفیف</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <div class="card-body">
        <div class="list-group">
            <label for="user" class="col-sm-2 control-label">کاربران</label>
            <ul class="nav nav-treeview list-group" id="user"  >

                @if($discount->users()->where())
                <li class="nav-item list-group" >همه کاربران</li>
                <li class="nav-item" >0-100</li>
                <li class="nav-item" >101-200</li>
                <li class="nav-item" >201 به بالا</li>
            </ul>
        </div>

        @php
            $categories =\App\Models\Category::all();

            foreach($categories as $category){
                if ($category->child->isEmpty()){
                    $lastLevelCategory[] = $category;
                }
            }
        $products = \App\Models\Product::all();
        @endphp

        <div class="list-group ">
            <label for="category"  class="col-sm-2 control-label">دسته بندی</label>
            <ul name="category[]" id="category" class="form-control" multiple>
                @foreach($lastLevelCategory as $category )
                    <li value="{{$category->id}}" name="{{$category->name}}" {{old($category->id) ? "selected" : ""}}>{{$category->name}}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group">
            <label for="product"  class="col-sm-2 control-label">محصولات</label>
            <ul name="product[]" id="product" class="form-control" multiple>
                @foreach($products as $product )
                    <li value="{{$product->id}}" name="{{$product->title}}" {{old($product->id) ? "selected" : ""}}>{{$product->title}}</li>
                @endforeach
            </ul>
        </div>
    </div>


@endcomponent
