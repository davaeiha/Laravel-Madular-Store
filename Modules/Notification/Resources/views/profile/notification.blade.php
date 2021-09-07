@extends('layouts.profile')

@section('in-box')

        <form class="space-y-5" method="post" action="{{route('profile.notifications.save')}}">
            @csrf
            @method('PATCH')

            @include('layouts.errors');

            <ul class="flex p-4 bg-gray-300 font-bold rounded list-inline">
                <li class="col-md-3 list-inline-item">عملیات</li>
                @foreach($channels as $channel)
                    <li class="col-md-{{$loop->last ? 2 : 3 }} list-inline-item">{{$channel->title}}</li>
                @endforeach
            </ul>

            @foreach($notifications as $notification)
                <ul class="flex  font-bold list-inline">
                    <li class="col-md-3 list-inline-item">{{$notification->title}}</li>
                    @foreach($channels as $key => $channel)
                        <li class="col-md-{{ $loop->last ? 2 : 3 }} list-inline-item">
                            <label class="flex items-center space-x-2 space-x-reverse">
                                <input class="form-checkbox w-4 h-4 rounded border border-gray-300 bg-gray-100 cursor-not-allowed"
                                       type="checkbox"
                                       name="notification[{{$notification->id}}][{{$channel->id}}]"
                                    {{!$notification->channels->contains($channel) ? 'disabled' : ''}} >
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endforeach

            <div class="card-footer">
                <button type="submit" class="btn btn-info">ثبت کانال ارتباطی</button>
                <a href="{{route("profile.notifications")}}" class="btn btn-default float-left">لغو</a>
            </div>

        </form>

@endsection
