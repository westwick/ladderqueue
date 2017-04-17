@extends('layouts.app')


@section('content')
<div class="forum-post">
    <div class="row">
        <div class="large-12 columns post">

            @if($parent->getDepth() > 0)
            <h4>{{$parent->getRoot()->title}}</h4>
            <p>
                You are viewing a child comment. <a href="{{$parent->getRoot()->id}}">View full thread</a>
            </p>
            @else
            <h4>{{$parent->title}}</h4>
            @endif

            <div class="panel comment">
                <p class="comment-author">
                    <a href="/u/{{strtolower($parent->author->name)}}">{{$parent->author->name}}</a>
                    <span class="cooldivider"></span>
                    {{$parent->created_at->diffForHumans()}}
                </p>
                <p class="comment-content">{{$parent->content}}</p>
            </div>

            <div class="panel post-reply">
                <form method="post" action="/post-comment">
                    {{ csrf_field() }}
                    <input type="hidden" name="parent_id" value="{{$parent->id}}" />
                    <textarea placeholder="type your reply here" name="content"></textarea>
                    <button type="submit" class="button">Reply</button>
                </form>
            </div>

            @if(count($comments) > 0)
            <div class="panel post">
                @include('partials.comments', ['comments' => $comments, 'endLoop' => false])
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.reply').click(function(e) {
                e.preventDefault();

                $(this).siblings('.replier').show();
            })

            $('.hideyakids').click(function(e) {
                e.preventDefault();
                console.log($(this).closest('.comment'))
                $(this).closest('.comment').children('.comment').hide();
            });
        });
    </script>
@endsection