@extends('layouts.profLayout')


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
    <form action="{{url('two-factor-auth')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="type">نوع:</label>
            <select name="type" class="form-control" id="">
{{--                <option value="off">off</option>--}}
{{--                <option value="sms">sms</option>--}}
                @foreach(config('two-factor-auth.type') as $key => $value)
                    <option value="{{$key}}" name="{{$key}}" {{old($key) || auth()->user()->select2FacAuth($key) ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <lable for="phone">شماره همراه:</lable>
            <input type="text" class="form-control" name="phone" placeholder="please add your phone number" value="{{old('phone') ?? auth()->user()->phone_number}}">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">
                به روز رسانی
            </button>
        </div>
    </form>
@endsection

