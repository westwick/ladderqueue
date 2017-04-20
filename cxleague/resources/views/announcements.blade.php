@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-6 columns medium-centered">
            @foreach($announcements as $a)
                <div class="panel">
                    <h3>{{$a->title}}</h3>
                    <p>{{$a->message}}</p>
                    <p class="nomargin" style="font-size: 14px">
                        Posted by <strong>{{$a->author}}</strong> on {{$a->created_at->toDateString()}}
                    </p>
                </div>
            @endforeach
        </div>
    </section>
@endsection