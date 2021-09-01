@extends('layouts.app')

@section('script')
    <script >

        $('#sendComment').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) // Button that triggered the modal
            let parent_id = button.data('id');
            // var subject_id = button.data('id'); // Extract info from data-* attributes
            // var subject_type = button.data('type'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            let modal = $(this)
            modal.find('input[name="parent_id"]').val(parent_id)
            // modal.find('.modal-body #subject_id').val(subject_id)
            // modal.find('.modal-body #subject_type').val(subject_type)
        })
        document.querySelector('#sendCommentForm').addEventListener('submit' , function(event) {
            event.preventDefault();
            let target = event.target;

            let data = {
                commentable_id : target.querySelector('input[name="commentable_id"]').value,
                commentable_type: target.querySelector('input[name="commentable_type"]').value,
                parent_id: target.querySelector('input[name="parent_id"]').value,
                comment: target.querySelector('textarea[name="comment"]').value
            }

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            })


            $.ajax({
                type : 'POST',
                url : "{{route('send.comment')}}",
                data : JSON.stringify(data),
                success : function(data) {
                    console.log(data);
                },
                error : function (){
                    console.log("error");
                }
            })
        })


    </script>
@endsection

@section('content')
    @auth
        <div class="modal fade" id="sendComment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route("send.comment",$product->id)}}" method="post" id="sendCommentForm" >
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="commentable_id" value="{{$product->id}}">
                            <input type="hidden" name="commentable_type" value="{{get_class($product)}}">
                            <input type="hidden" name="parent_id" value="0">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                <textarea name="comment" class="form-control" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ارسال نظر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   @endauth
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ">
                        {{ $product->title }}
                        <form action="{{route("cart.add",$product->id)}}" method="post" id="add-to-cart">
                            @csrf
                        </form>
                        @if(\Modules\Cart\Helpers\Cart::count($product) < $product->inventory)
                            <span class="btn btn-sm btn-danger" onclick="document.getElementById('add-to-cart').submit()" >افزودن به سبد خرید </span>
                        @endif
                    </div>

                    <div class="card-body">
                        @if( $product->categories)
                            @foreach( $product->categories as $cate)
                                <a href="#">{{ $cate->name }}</a>
                            @endforeach
                        @endif
                        <br>
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
        @guest()
            <div class="alert alert-info mt-3"><a href="{{route("login")}}">برای ثبت نظر لطفا وارد سایت شوید</a></div>
        @endguest
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-4">بخش نظرات</h4>
                    @auth()
                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="0" data-type="product">ثبت نظر جدید</span>
                    @endauth
                </div>
               @include("comment::layouts.comments",["comments"=>$product->comments()->where("parent_id",0)->get()])
            </div>
        </div>
    </div>
@endsection
