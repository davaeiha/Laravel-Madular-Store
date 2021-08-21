@component("admin.layout.content",["title"=>"دسترسی ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">دسترسی ها</li>
        </ol>
    @endslot


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">دسترسی ها</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @can('create-permission')
                        <div class="input-group input-group-sm" style="width: 200px;">
                           <div class="btn-group-sm mr-1">
                                <a href="{{route("admin.permission.create")}}" class="btn btn-info">ایجاد دسترسی جدید</a>
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
                        <th>نام دسترسی</th>
                        <th>توضیح دسترسی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->label}}</td>
                            <td class="d-flex ">
                                @can('delete-permission')
                                <form action="{{route("admin.permission.destroy",["permission"=>$permission->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
                                @can('edit-permission')
                                    <a href="{{route("admin.permission.edit",["permission"=>$permission->id])}}" class="btn btn-sm btn-primary">ویرایش</a>
                                @endcan
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$permissions->appends(["search"=>request('search')])->render()}}
            </div>
        </div>
        <!-- /.card -->

    </div>


@endcomponent
