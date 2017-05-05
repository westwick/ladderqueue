@extends('layouts.app')


@section('content')


    <div class="row">
        <div class="large-12 columns">
            <div class="new-post text-right">
                <a class="new-post-btn button" href="/forum/post">New Post</a>
            </div>
            <div class="panel">
                @foreach($comments as $comment)
                    <div class="board-post">
                        <p class="post-title">
                            {{$comment->title}}
                        </p>
                        <p class="post-author">
                            Posted by {{$comment->author->name}} {{$comment->created_at->diffForHumans()}}
                        </p>
                        <p class="post-comments">
                            <a href="/forum/post/{{$comment->id}}">{{$comment->descendants()->count()}} comments</a>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection