@component("admin.layout.content",["title"=>"کانال ارتباطی "])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">کانال ارتباطی </li>
        </ol>
    @endslot


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">کانال ارتباطی </h3>
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
                                <a href="{{route("admin.channels.create")}}" class="btn btn-info">ایجاد کانال ارتباطی جدید</a>
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
                        <th>نام کانال ارتباطی</th>
                        <th>توضیح کانال ارتباطی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($channels as $channel)
                        <tr>
                            <td>{{$channel->title}}</td>
                            <td>{{$channel->description}}</td>
                            <td class="d-flex ">
                                @can('delete-channel')
                                <form action="{{route("admin.channels.destroy",["channel"=>$channel->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
                                @can('edit-channel')
                                    <a href="{{route("admin.channels.edit",["channel"=>$channel->id])}}" class="btn btn-sm btn-primary">ویرایش</a>
                                @endcan
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$channels->links()}}
            </div>
        </div>
        <!-- /.card -->

    </div>


@endcomponent
