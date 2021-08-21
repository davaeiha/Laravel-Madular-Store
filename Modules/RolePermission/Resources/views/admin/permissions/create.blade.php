@component("admin.layout.content",["title"=>"فرم ایجاد کاربر"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">قرم ایجاد دسترسی</li>
        </ol>


    @endslot


    <div class="card-header">
        <h3 class="card-title">ایجاد دسترسی</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.permission.store")}}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام دسترسی</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" placeholder="نام دسترسی را وارد کنید">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح دسترسی</label>

                <div class="col-sm-10">
                    <input type="text" name="label" class="form-control" id="inputName4" placeholder="توضیح دسترسی را وارد کنید">
                </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت دسترسی</button>
            <a href="{{route("admin.permission.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
