@component("admin.layout.content",["title"=>"محصولات"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">محصولات</li>
        </ol>
    @endslot


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">محصولات</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @can('create-product')
                        <div class="input-group input-group-sm" style="width: 200px;">
                           <div class="btn-group-sm mr-1">
                                <a href="{{route("admin.products.create")}}" class="btn btn-info">ایجاد محصول جدید</a>
                           </div>
                        </div>
                    @endcan
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>نام محصول</th>
                        <th>توضیح محصول</th>
                        <th>قیمت محصول</th>
                        <th>موجودی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->title}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->inventory}}</td>
                            <td class="d-flex ">
                                @can('delete-product')
                                <form action="{{route("admin.products.destroy",["product"=>$product->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
                                @can('edit-product')
                                    <a href="{{route("admin.products.edit",["product"=>$product->id])}}" class="btn btn-sm btn-primary">ویرایش</a>

                                    <a href="{{route("admin.product.gallery.index",["product"=>$product->id])}}" class="btn btn-sm mr-1 btn-info btn-primary">گالری تصاویر</a>
                                @endcan
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
{{--            <div class="card-footer">--}}
{{--                {{$products->render()}}--}}
{{--            </div>--}}
        </div>
        <!-- /.card -->

    </div>


@endcomponent
