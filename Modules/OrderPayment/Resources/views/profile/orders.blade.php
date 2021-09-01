@extends('layouts.profLayout');

@section('in-box')
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>آیدی سفارش</th>
                <th>زمان ثبت سفارش</th>
                <th>وضعیت سفارش</th>
                <th>هزینه سفارش</th>
                <th>کد رهگیری پستی</th>
                <th>اقدامات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{jdate($order->created_at)->format('%B %d، %Y')}}</td>
                    <td>{{$order->status}}</td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->trcking_serial ?? 'مرسوله پست نشده'}}</td>
                    <td>
                        <a href="{{route('profile.order.detail',$order->id)}}" class="btn btn-sm btn-dark">جزییات سفارش</a>
                        @if($order->status == "unpaid")
                            <a href="{{route('profile.order.pay',$order->id)}}" class="btn btn-sm btn-light ml-3"> پرداخت </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $orders->links() }}
    </div>

@endsection
