@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="large-12 columns">

            <div class="panel">
                @foreach($comments as $comment)
                    <p>
                        {{$comment->author->name}}: {{$comment->content}}
                        <a href="/forum/post/{{$comment->id}}">View Post</a>
                    </p>

                @endforeach
            </div>
        </div>
    </div>

@endsection