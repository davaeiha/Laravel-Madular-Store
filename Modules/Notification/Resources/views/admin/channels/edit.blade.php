@component("admin.layout.content",["title"=>"دسترسی ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">کانال ارتباطی </li>
        </ol>
    @endslot


    <div class="card-header">
        <h3 class="card-title">ویرایش کانال ارتباطی </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.channels.update",["channel"=>$channel->id])}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام کانال ارتباطی</label>

                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputName3" value="{{old("name",$channel->title)}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح</label>

                <div class="col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputName4" value="{{old("label",$channel->description)}}">
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت کانال ارتباطی</button>
            <button type="submit" class="btn btn-default float-left">لغو</button>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
