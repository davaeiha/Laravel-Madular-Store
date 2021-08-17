@component("admin.layout.content",["title"=>"محصولات"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">محصولات</li>
        </ol>
    @endslot

    @slot('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            // set file link
            function fmSetLink($url) {
                document.getElementById('image_label').value = $url;
            }


        </script>
    @endslot

    <div class="card-header">
        <h3 class="card-title">ویرایش محصول</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.products.update",["product"=>$product->id])}}" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام محصول</label>

                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputName3" placeholder="نام محصول را وارد کنید" value="{{old('title',$product->title)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح محصول</label>
                <textarea class="form-control" name="description" id="inputName4" cols="30" rows="10" >{{old("description",$product->description)}}</textarea>
            </div>

            <div class="form-group">
                <label for="inputName5" class="col-sm-2 control-label">قیمت</label>

                <div class="col-sm-10">
                    <input type="number" name="price" class="form-control" id="inputName5" placeholder="قیمت محصول را وارد کنید" value="{{old("price",$product->price)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName6" class="col-sm-2 control-label">موجودی</label>

                <div class="col-sm-10">
                    <input type="number" name="inventory" class="form-control" id="inputName6" placeholder="تعداد کالای موجود در انبار" value="{{old('inventory',$product->inventory)}}">
                </div>
            </div>

            <div class="form-group">
                <label for="file"class="control-label col-sm-2">تست بارگذاری تصویر</label>
                <div class="col-sm-10">
                    <input type="file" name="test" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">آپلود تصویر شاخص</label>
                <div class="input-group">
                    <input type="text" id="image_label" class="form-control mb-2" name="image"
                           aria-label="Image" aria-describedby="button-image" dir="ltr" value="{{$product->image}}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب </button>
                    </div>
                </div>
                <hr>
                <img src="{{$product->image}}" class="w-25" alt="">
            </div>

            @php
                $categories =\App\Models\Category::all();

                foreach($categories as $category){
                    if ($category->child->isEmpty()){
                        $lastLevelCategory[] = $category;
                    }
                }
            @endphp
            <div class="form-group">
                <label for="category"  class="col-sm-2 control-label">دسته بندی</label>
                <select name="category[]" id="category" class="form-control" multiple>

                    @foreach($lastLevelCategory as $category )
                        <option value="{{$category->id}}" name="{{$category->name}}" {{$product->categories->contains($category) ? "selected" : ""}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ویرایش محصول</button>
            <a href="{{route("admin.products.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
