@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item ">
                                <a href="{{route('index')}}" class="nav-link {{request()->is('profile') ? 'active' : ''}}">صفحه اصلی</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('two-fac-auth')}}" class="nav-link {{request()->is('profile/two-factor-auth') ? 'active ' : ''}}">احراز دو مرحله ای</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('profile.orders')}}" class="nav-link {{request()->is('profile/orders') ? 'active ' : ''}}">سفارشات</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @yield('in-box')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
