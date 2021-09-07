@component("admin.layout.content",["title"=>"فرم ایجاد اعلان"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">قرم ایجاد مقام</li>
        </ol>


    @endslot


    <div class="card-header">
        <h3 class="card-title">ایجاد اعلان</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.notifications.store")}}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام اعلان</label>

                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputName3" placeholder="نام اعلان را وارد کنید" value="{{old("name") ?? ""}}">
                </div>
            </div>

            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح اعلان</label>

                <div class="col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputName4" placeholder="توضیح اعلان را وارد کنید" value="{{old("label") ?? ""}}">
                </div>
            </div>

            <div class="form-group">
                <label for="channels"  class="col-sm-2 control-label">اجازه دسترسی ها</label>
                <select name="channels[]" id="channels" class="form-control"  multiple>
                    @foreach($channels as $channel )
                        <option value="{{$channel->id}}" name="{{$channel->title}}">{{$channel->description}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت اعلان</button>
            <a href="{{route("admin.notifications.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
