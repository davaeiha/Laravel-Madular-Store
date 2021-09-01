@component("admin.layout.content",["title"=>"فرم ویرایش کاربر"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">فرم ویرایش کاربر</li>
        </ol>
    @endslot


    <div class="card-header">
        <h3 class="card-title">ویرایش کاربر</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.users.update",["user"=>$user->id])}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام کاربر</label>

                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName3" value="{{$user->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">ایمیل</label>

                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail3" value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">پسورد</label>

                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="پسورد را وارد کنید">
                </div>
            </div>
            <div class="form-group">
                <label for="password-confirm" class="col-sm-2 control-label">تایید پسوورد</label>

                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="پسورد را تکرار کنید">
                </div>
            </div>
            @if(!$user->hasVerifiedEmail())
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="form-check">
                            <input type="checkbox" name="verify" class="form-check-input" id="exampleCheck2">
                            <label class="form-check-label" for="exampleCheck2">اکانت فعال باشد</label>
                        </div>
                    </div>
                </div>
            @endif


        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت کاربر</button>
            <button type="submit" class="btn btn-default float-left">لغو</button>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
