@component("admin.layout.content",["title"=>"دسته بندی ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">دسته بندی ها</li>
        </ol>
    @endslot
    @slot("head")

        <style>
            li.list-group-item > ul.list-group{
                margin-top: 15px;
            }
        </style>

    @endslot
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">دسته بندی ها</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @can('create-category')
                        <div class="input-group input-group-sm" style="width: 200px;">
                           <div class="btn-group-sm mr-1">
                                <a href="{{route("admin.categories.create")}}" class="btn btn-info">ایجاد دسته بندی جدید</a>
                           </div>
                        </div>
                    @endcan
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                @include('admin.layout.categories' , ['categories' => $categories])
            </div>
            <!-- /.card-body -->
{{--            <div class="card-footer">--}}
{{--                {{$categories->render()}}--}}
{{--            </div>--}}
        </div>
        <!-- /.card -->

    </div>


@endcomponent
