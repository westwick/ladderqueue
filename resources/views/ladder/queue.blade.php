@extends('layouts.app')


@section('content')

    @if($canQueue)
        <playerqueue :initplayers="{{$players}}" :initgame="{{ $game !== NULL ? $game : '{}' }}"></playerqueue>
    @else
        <div class="row">
            <div class="medium-9 large-6 medium-centered columns">
                <div class="panel text-center">
                    <p>In order to join the queue you must register for the Continental Ladder.</p>
                    <div style="margin: 2rem 0">
                        <a href="/ladder/register" class="button" style="margin: 0;">Ladder Registration</a>
                    </div>
                    <div>
                        <p>Or you can <a href="#">learn more</a> about the Continental Ladder first.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection