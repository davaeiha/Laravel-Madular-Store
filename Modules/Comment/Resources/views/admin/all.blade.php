@component("admin.layout.content",["title"=>"مقام ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">بخش نظرات</li>
        </ol>
    @endslot



    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> تایید شده نظرات</h3>
                <div class="card-tools d-flex">

                    <form action="">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </form>

                    <div class="input-group input-group-sm" style="width: 200px;">
                        <div class="btn-group-sm mr-1">
                            <a href="{{route("admin.comments.unapproved")}}" class="btn btn-info">نظرات تایید نشده</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>آیدی کاربر</th>
                        <th>آیدی محصول</th>
                        <th>آیدی کامنت پدر</th>
                        <th>متن کامنت</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{$comment->user_id}}</td>
                            <td>{{$comment->commentable_id}}</td>
                            <td>{{$comment->parent_id}}</td>
                            <td>{{$comment->comment}}</td>
                            <td class="d-flex ">
                                @can('delete-comment')
                                <form action="{{route("admin.comments.destroy",["comment"=>$comment->id])}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger ml-1">حذف</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$comments->links()}}
            </div>
        </div>
        <!-- /.card -->

    </div>


@endcomponent
