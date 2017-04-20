@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="large-12 columns">

            <div class="panel post-thread">
                <form method="post" action="/post-thread">
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Post Title" />
                    <textarea placeholder="Post Content" name="content"></textarea>
                    <button type="submit" class="button">Post</button>
                </form>
            </div>

        </div>
    </div>

@endsection