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
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.discounts.store")}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="occasion" class="col-sm-2 control-label">نام مناسبت تخفیف</label>

                <div class="col-sm-10">
                    <input type="text" name="occasion" class="form-control" id="occasion" placeholder="نام مناسبت را وارد کنید" value="{{old('occasion') ?? ''}}">
                </div>
            </div>


            <div class="form-group">
                <label for="code" class="col-sm-2 control-label">کد تخفیف</label>
                <div class="col-sm-10">
                    <input type="text" name="code" class="form-control" id="code" placeholder="کد تخفیف را وارد کنید" value="{{old('code') ?? ''}}">
                </div>
            </div>

            <div class="form-group">
                <label for="percent" class="col-sm-2 control-label">درصد تخفیف</label>
                <div class="col-sm-10">
                    <input type="number" name="percent" class="form-control" id="percent" placeholder="درصد تخفیف را وارد کنید" value="{{old('percent') ?? ''}}">
                </div>
            </div>

            <div class="form-group">
                <label for="expired_at" class="col-sm-2 control-label">تاریخ انقضا</label>
                <div class="col-sm-10">
                    <input type="date" name="expired_at" class="form-control" id="expired_at" placeholder="تاریخ انقضای تخفیف را وارد کنید" value="{{old('expired_at') ?? '' }}">
                </div>
            </div>

            <div class="form-group">
                <label for="user" class="col-sm-2 control-label">کاربران</label>
                <select name="user" id="user" class="form-control" >
                    <option value="all" name="all" {{old('all') ? 'selected' : '' }}>همه کاربران</option>
                    <option value="low" name="low" {{old('low') ? 'selected' : ''}}>0-100</option>
                    <option value="middle" name="middle" {{old('low') ? 'selected' : ''}}>101-200</option>
                    <option value="high" name="high" {{old('low') ? 'selected' : ''}}>201 به بالا</option>
                </select>
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

            <div class="form-group">
                <label for="category"  class="col-sm-2 control-label">دسته بندی</label>
                <select name="category[]" id="category" class="form-control" multiple>
                    @foreach($lastLevelCategory as $category )
                        <option value="{{$category->id}}" name="{{$category->name}}" {{old($category->id) ? "selected" : ""}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="product"  class="col-sm-2 control-label">محصولات</label>
                <select name="product[]" id="product" class="form-control" multiple>
                    @foreach($products as $product )
                        <option value="{{$product->id}}" name="{{$product->title}}" {{old($product->id) ? "selected" : ""}}>{{$product->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت تخفیف</button>
            <a href="{{route("admin.discounts.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->

    </form>


@endcomponent
