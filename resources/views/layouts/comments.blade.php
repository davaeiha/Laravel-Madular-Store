@foreach($comments as $comment)

        <div class="card {{!$loop->first ? 'mt-3' : ''}}">
        <div class="card-header d-flex justify-content-between">
            <div class="commenter d-flex">
                <span>{{$comment->user->name}}</span>
                <span class="text-muted"> - {{jdate($comment->created_at)->ago()}}</span>
            </div>
            @auth()
                @if($comment->parent_id == 0)
                    <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="{{$comment->id}}" data-type="product">پاسخ به نظر</span>
                @endif
            @endauth
        </div>

        <div class="card-body">
            {{$comment->comment}}
{{--            @foreach($comment->childComments as $childComment)--}}
{{--                <div class="card mt-3">--}}
{{--                    <div class="card-header d-flex justify-content-between">--}}
{{--                        <div class="commenter">--}}
{{--                            <span>{{$childComment->user->name}}</span>--}}
{{--                            <span class="text-muted">- دو دقیقه قبل</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        {{$childComment->comment}}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}

            @include("layouts.comments",["comments"=>$comment->childComments])
        </div>
    </div>
@endforeach