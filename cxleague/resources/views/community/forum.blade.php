@extends('layouts.app')


@section('content')


    <div class="row">
        <div class="large-12 columns">
            <div class="new-post text-right">
                <a class="new-post-btn button" href="/forum/post">New Post</a>
            </div>
            <div class="panel nomargin">
                @foreach($comments as $comment)
                    <p>
                        {{$comment->author->name}}: {{$comment->title}}
                        <a href="/forum/post/{{$comment->id}}">View Post</a>
                    </p>

                @endforeach
            </div>
        </div>
    </div>

@endsection