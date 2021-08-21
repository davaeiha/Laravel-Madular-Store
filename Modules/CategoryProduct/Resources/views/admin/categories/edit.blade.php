@component("admin.layout.content",["title"=>"فرم ایجاد دسته بندی"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">قرم ویرایش دسته بندی</li>
        </ol>

    @endslot

    <div class="card-header">
        <h3 class="card-title">ویرایش دسته بندی</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.categories.update",$category->id)}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام دسته بندی</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" placeholder="نام دسته بندی را وارد کنید" value="{{old("name",$category->name)}}">
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ویرایش دسته بندی</button>
            <a href="{{route("admin.categories.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>

@endcomponent
