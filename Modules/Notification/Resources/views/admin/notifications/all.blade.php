@component("admin.layout.content",["title"=>"اعلان ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">مقام ها</li>
        </ol>
    @endslot



    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">اعلان ها</h3>
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
                                <a href="{{route("admin.notifications.create")}}" class="btn btn-info">ایجاد اعلان جدید</a>
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
                        <th>نام اعلان</th>
                        <th>توضیح اعلان</th>
                        <th>کانال های ارتباطی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{$notification->title}}</td>
                            <td>{{$notification->description}}</td>
                            <td>
                                <ul class="font-bold list-inline">
                                    @foreach($notification->channels as $channel)
                                        <li class="list-inline-item">{{$channel->title}} -</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="d-flex ">
                                @can('delete-notification')
                                <form action="{{route("admin.notifications.destroy",["notification"=>$notification->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
{{--                                @can("edit-notification",$notification)--}}
                                @can("edit-notification")
                                <a href="{{route("admin.notifications.edit",["notification"=>$notification->id])}}" class="btn btn-sm btn-primary">ویرایش</a>
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
                {{$notifications->links()}}
            </div>
        </div>
        <!-- /.card -->

    </div>


@endcomponent
