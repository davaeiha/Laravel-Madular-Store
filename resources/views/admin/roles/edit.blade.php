@component("admin.layout.content",["title"=>"مقام ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">مقام ها</li>
        </ol>
    @endslot


    <div class="card-header">
        <h3 class="card-title">ویرایش کاربر</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.roles.update",["role"=>$role->id])}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام مقام</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" value="{{old("name",$role->name)}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح</label>

                <div class="col-sm-10">
                    <input type="text" name="label" class="form-control" id="inputName4" value="{{old("name",$role->label)}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="permissions"  class="col-sm-2 control-label">اجازه دسترسی ها</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach(\App\Models\Permission::all() as $permission )
                    <option value="{{$permission->id}}" name="{{$permission->name}}" {{$role->permissions->contains($permission) ? "selected" : "" }}> {{$permission->label}} </option>
                @endforeach
            </select>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت مقام</button>
            <a href="{{route("admin.roles.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
