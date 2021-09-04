@extends('layouts.profile')


@section('in-box')
    <h4>احراز دو مرحله ای</h4>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>


    @endif
    <form action="{{route('profile.2FA.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="type">نوع:</label>
            <select name="type" class="form-control" id="">
                @foreach(config('twofacauth.type') as $key => $value)
                    <option value="{{$key}}" name="{{$key}}" {{old($key) || auth()->user()->select2FacAuth($key) ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <lable for="phone">شماره همراه:</lable>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="please add your phone number" value="{{old('phone') ?? auth()->user()->phone_number}}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                به روز رسانی
            </button>
        </div>
    </form>
@endsection

