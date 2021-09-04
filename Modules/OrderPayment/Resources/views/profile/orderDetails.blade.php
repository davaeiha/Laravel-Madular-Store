@extends('layouts.profile')

@section('in-box')
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>نام محصول</th>
                <th>قیمت محصول</th>
                <th>تعداد محصول</th>
                <th>هزینه کل</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)

                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{$product->price * $product->pivot->quantity}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

@endsection
