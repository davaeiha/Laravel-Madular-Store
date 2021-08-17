@component("admin.layout.content",["title"=>"دسترسی ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">دسترسی ها</li>
        </ol>
    @endslot


    <div class="card-header">
        <h3 class="card-title">ویرایش کاربر</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.permission.update",["permission"=>$permission->id])}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام دسترسی</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" value="{{old("name",$permission->name)}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح</label>

                <div class="col-sm-10">
                    <input type="text" name="label" class="form-control" id="inputName4" value="{{old("label",$permission->label)}}">
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت دسترسی</button>
            <button type="submit" class="btn btn-default float-left">لغو</button>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
