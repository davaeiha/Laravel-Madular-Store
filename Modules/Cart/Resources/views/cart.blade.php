@extends('layouts.app')
@section("script")
    <script type="text/javascript">

        function changeQuantity(event, id , cartName = null) {
            //
            event.preventDefault();

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            });


            //
            $.ajax({
                type : 'POST',
                url : "{{route('cart.update')}}",
                data : JSON.stringify({
                    id : id ,
                    quantity : event.target.value,
                    // cart : cartName,
                    _method : 'PATCH'
                }),
                success : function(res) {
                    location.reload();
                }
            });
        }

    </script>

@endsection


@section('content')
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>سبد خرید</h2>
            </div>
            @php
                $carts =\Modules\Cart\Helpers\Cart::all();


            @endphp
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                        <tr>
                            <!-- Set columns width -->
                            <th class="text-center py-3 px-4" style="min-width: 400px;">نام محصول</th>
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت واحد</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">تعداد</th>
                            @if(!\Modules\Cart\Helpers\Cart::isAllWithoutDiscount())
                                <th class='text-right py-3 px-4' style='width: 150px;'>درصد تخفیف</th>
                            @endif
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت نهایی</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($carts as $cart)
                            @php
                                $product=$cart["product"];
                            @endphp
                            @if(isset($product))

                                <tr>
                                    <td class="p-4">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="#" class="d-block text-dark">{{$product->title}}</a>
{{--                                                <small>--}}
{{--                                                    @foreach($product->attributes as $attr)--}}
{{--                                                        <span class="text-muted">{{$attr->name}}</span> {{$attr->pivot->value->value}}--}}
{{--                                                    @endforeach--}}
{{--                                                </small>--}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right font-weight-semibold align-middle p-4">{{$product->price}}</td>

                                    <td class="align-middle p-4">
                                        <select name="quantity" onchange="changeQuantity(event, '{{ $cart['id'] }}')" class="form-control text-center">

                                            @foreach( range(1,$cart['product']->inventory) as $quantity)
                                                <option value="{{$quantity}}" {{$cart["quantity"]==$quantity ? "selected" : ''}}> {{$quantity}} </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    @if(!\Modules\Cart\Helpers\Cart::isAllWithoutDiscount())
                                        <td class="text-right font-weight-semibold align-middle p-4">{{$cart['discount_percentage'] != 0 ? $cart['discount_percentage'] : 'شامل تخفیف نمی شود'}}</td>
                                    @endif
                                    @php
                                        $totalPrice = $cart["quantity"] * $product->price *(1 - $cart['discount_percentage']/100)
                                    @endphp
                                    <td class="text-right font-weight-semibold align-middle p-4">{{$totalPrice}}</td>

                                    <form action="{{route("cart.remove",["id"=>$cart["id"]])}}" method="post" id="remove-cart">
                                        @csrf
                                        @method("delete")
                                    </form>
                                    <td class="text-center align-middle px-0">
                                        <span onclick="event.preventDefault();document.getElementById('remove-cart').submit()" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- / Shopping cart table -->
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    @if(in_array('images',array_keys(\Nwidart\Modules\Facades\Module::allEnabled())))
                        @if(\Modules\Cart\Helpers\Cart::isAllWithoutDiscount())
                            <div class="mt-4">
                                <form action="{{route('discount.check')}}" method="post">
                                    @csrf
                                    <input type="text" name="code" id="code" class="form-control" placeholder="کد تخفیف دارید؟">
                                    <button type="submit" class="btn btn-success mt-1 " >اعمال تخفیف</button>
                                    @if($errors->has('discount'))
                                        <span class="text-danger text-sm mt-2">{{$errors->first('discount')}}</span>
                                    @endif
                                </form>
                            </div>
                        @else
                            <div class="mt-4">
                                <form action="{{route('discount.destroy')}}" method="POST" id="delete-discount">
                                    @csrf
               j                     @method('delete')
                                </form>

                                <span class="">  کد تخفیف: <span class="text-info  "> {{\Modules\Cart\Helpers\Cart::getDiscount()->code}} </span> </span><br>
                                <span class="">  درصد تخفیف: <span class="text-info  "> {{\Modules\Cart\Helpers\Cart::getDiscount()->percent}} درصد </span> </span>

                                <button type="button" class="btn btn-danger btn-sm " onclick="event.preventDefault();document.getElementById('delete-discount').submit()" >حذف</button>
                            </div>
                        @endif
                    @endif
                    <div class="d-flex">
                        {{--                        <div class="text-right mt-4 mr-5">--}}
                        {{--                            <label class="text-muted font-weight-normal m-0">images</label>--}}
                        {{--                            <div class="text-large"><strong>$20</strong></div>--}}
                        {{--                        </div>--}}
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">قیمت کل</label>
                            <div class="text-large"><strong>{{$carts->sum(function ($cart){ return $cart["price"] * $cart["quantity"]; })}}</strong></div>
                        </div>
                    </div>
                </div>

                <div class="float-left">
                    <form action="{{route("payment.post")}}" method="post" id="payment">
                        @csrf
                    </form>

                    <button type="button" onclick="event.preventDefault();document.getElementById('payment').submit()" class="btn btn-lg btn-primary mt-2">پرداخت</button>
                </div>

            </div>
        </div>
    </div>
@endsection



