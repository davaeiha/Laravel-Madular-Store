@component("admin.layout.content",["title"=>"اعلان ها"])
    @slot("breadcrumb")
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
            <li class="breadcrumb-item active">اعلان ها</li>
        </ol>
    @endslot


    <div class="card-header">
        <h3 class="card-title">ویرایش اعلان</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include("layouts.errors")
    <form class="form-horizontal" method="post" action="{{route("admin.notifications.update",$notification->id)}}">
        @csrf
        @method("PATCH")
        <div class="card-body">
            <div class="form-group">
                <label for="inputName3" class="col-sm-2 control-label">نام اعلان</label>

                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputName3" value="{{old("name",$notification->title)}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName4" class="col-sm-2 control-label">توضیح</label>

                <div class="col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputName4" value="{{old("name",$notification->description)}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="channels"  class="col-sm-2 control-label">کانال های ارتباطی مورد نیاز</label>
            <select name="channels[]" id="channels" class="form-control"  multiple>
                @foreach($channels as $channel )
                    <option value="{{$channel->id}}" name="{{$channel->title}}" {{$notification->channels->contains($channel) ? 'selected' : ''}}>{{$channel->description}}</option>
                @endforeach
            </select>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">ثبت اعلان</button>
            <a href="{{route("admin.notifications.index")}}" class="btn btn-default float-left">لغو</a>
        </div>
        <!-- /.card-footer -->
    </form>



@endcomponent
