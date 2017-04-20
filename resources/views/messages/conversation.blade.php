@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-4 columns">
            <p class="messages-header">Recent Messages</p>
            <conversations :convos="{{Auth::user()->conversations()->orderBy('updated_at', 'desc')->get()}}" :max-items="3"></conversations>
        </div>
        <div class="medium-8 columns">
            <p class="text-right messages-header">Conversation with <a href="/u/{{$recipient->name}}">{{$recipient->name}}</a></p>
            <messages :msgs="{{$messages}}" :recipient="{{$recipient}}" :user="{{Auth::user()}}" :convoid="{{$convoid}}"></messages>
        </div>
    </section>
@endsection