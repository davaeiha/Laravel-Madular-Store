@component("admin.layout.content",["title"=>"مقام ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">مقام ها</li>
        </ol>
    @endslot



    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">مقام ها</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    @can('create-role')
                        <div class="input-group input-group-sm" style="width: 200px;">
                           <div class="btn-group-sm mr-1">
                                <a href="{{route("admin.roles.create")}}" class="btn btn-info">ایجاد مقام جدید</a>
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
                        <th>نام مقام</th>
                        <th>توضیح مقام</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->name}}</td>
                            <td>{{$role->label}}</td>
                            <td class="d-flex ">
                                @can('delete-role')
                                <form action="{{route("admin.roles.destroy",["role"=>$role->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
{{--                                @can("edit-role",$role)--}}
                                @can("edit-role")
                                <a href="{{route("admin.roles.edit",["role"=>$role->id])}}" class="btn btn-sm btn-primary">ویرایش</a>
                                @endcan
{{--                                @endcan--}}
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$roles->links()}}
            </div>
        </div>
        <!-- /.card -->

    </div>


@endcomponent
