@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="large-12 columns">

            <div class="panel parent-comment">
                <p>{{$parent->author->name}}</p>
                <p>{{$parent->title}}</p>
                <p>{{$parent->content}}</p>
            </div>

            <div class="panel post-reply">
                <form method="post" action="/post-comment">
                    {{ csrf_field() }}
                    <input type="hidden" name="parent_id" value="{{$parent->id}}" />
                    <textarea placeholder="type your reply here" name="content"></textarea>
                    <button type="submit" class="button">Reply</button>
                </form>
            </div>

            <div class="panel post">
                @include('partials.comments', ['comments' => $comments, 'endLoop' => false])
            </div>
        </div>
    </div>

@endsection