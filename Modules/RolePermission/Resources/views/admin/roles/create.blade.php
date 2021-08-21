@component("admin.layout.content",["title"=>"فرم ایجاد مقام"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">قرم ایجاد مقام</li>
        </ol>


    @endslot


    <div class="card-header">
        <h3 class="card-title">ایجاد مقام</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.roles.store")}}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام مقام</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" placeholder="نام مقام را وارد کنید" value="{{old("name") ?? ""}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح مقام</label>

                <div class="col-sm-10">
                    <input type="text" name="label" class="form-control" id="inputName4" placeholder="توضیح مقام را وارد کنید" value="{{old("label") ?? ""}}">
                </div>
            </div>

            <div class="form-group">
                <label for="permissions"  class="col-sm-2 control-label">اجازه دسترسی ها</label>
                <select name="permissions[]" id="permissions" class="form-control"  multiple>
                    @foreach($permissions as $permission )
                        <option value="{{$permission->id}}" name="{{$permission->name}}">{{$permission->label}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت مقام</button>
            <a href="{{route("admin.roles.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
