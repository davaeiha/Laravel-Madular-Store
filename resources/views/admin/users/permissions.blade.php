@component("admin.layout.content",["title"=>"ثبت دسترسی"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">ثبت دسترسی</li>
        </ol>


    @endslot
    @slot("script")
        <script>
            $('#roles').select2({
                'placeholder':"مقام مورد نظر را انتخاب کنید"
            })
            $('#permissions').select2({
                'placeholder':"دسترسی مورد نظر را انتخاب کنید"
            })
        </script>

    @endslot


    <div class="card-header">
        <h3 class="card-title">ثبت دسترسی</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")

    <form class="form-horizontal" method="post" action="{{route("admin.users.permissions.store",["user"=>$user->id])}}">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="roles"  class="col-sm-2 control-label">مقام ها</label>
                <select name="roles[]" id="roles" class="form-control" multiple>
                    @foreach(\App\Models\Role::all() as $role)
                        <option value="{{$role->id}}" name="{{$role->name}}" {{$user->roles->contains($role) ? "selected" : ""}}>{{$role->label}}</option>
                    @endforeach
                </select>
            </div>

{{--            <div class="form-group">--}}
{{--                <label for="permissions"  class="col-sm-2 control-label">اجازه دسترسی ها</label>--}}
{{--                <select name="permissions[]" id="permissions" class="form-control"  multiple>--}}
{{--                    @foreach(\App\Models\Permission::all() as $permission )--}}
{{--                        <option value="{{$permission->id}}" name="{{$permission->name}}" {{$user->permissions->contains($permission) ? "selected" : ""}}>{{$permission->label}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت مقام</button>
            <a href="{{route("admin.users.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
