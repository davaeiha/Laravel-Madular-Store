@component("admin.layout.content",["title"=>"تخفیفات"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">تخفیفات</li>
        </ol>
    @endslot


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">تخفیفات</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @can('create-discount')
                        <div class="input-group input-group-sm" style="width: 200px;">
                           <div class="btn-group-sm mr-1">
                                <a href="{{route("admin.discounts.create")}}" class="btn btn-info">ایجاد تخفیف جدید</a>
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
                        <th>آیدی تخفیف</th>
                        <th>مناسبت تخفیف</th>
                        <th>کد تخفیف</th>
                        <th>درصد تخفیف</th>
                        <th>تاریخ انقضا</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $discount)
                        <tr>
                            <td>{{$discount->id}}</td>
                            <td>{{$discount->occasion}}</td>
                            <td>{{$discount->code}}</td>
                            <td>{{$discount->percent}}</td>
                            <td>{{$discount->expired_at}}</td>
                            <td class="d-flex ">
                                @can('delete-discount')
                                <form action="{{route("admin.discounts.destroy",["discount"=>$discount->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
                                @can('edit-discount')
                                    <a href="{{route("admin.discounts.edit",["discount"=>$discount->id])}}" class="btn btn-sm btn-primary">ویرایش</a>
                                @endcan
{{--                                    <a href="{{route("admin.discounts.show",["discount"=>$discount->id])}}" class="btn btn-sm btn-info mr-1">جزییات تخفیف</a>--}}
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
{{--            <div class="card-footer">--}}
{{--                {{$discounts->render()}}--}}
{{--            </div>--}}
        </div>
        <!-- /.card -->

    </div>


@endcomponent
