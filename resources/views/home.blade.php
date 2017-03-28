@extends('layouts.app')

@section('content')

@if(! Auth::user()->steam_verified)
    <section class="row main-top-padder padbot">
        <div class="medium-6 medium-centered columns">
            <div class="panel no-steam-auth">
                <p class="text-center">
                    You must authenticate with Steam to use CarbonX.
                </p>

                <p class="text-center">
                    <a href="/steam/auth"><img src="/images/steam-signin.png" /></a>
                </p>
            </div>
        </div>
    </section>
@else

    <playerqueue :initplayers="{{$players}}" :initgame="{{ $game !== NULL ? $game : '{}' }}"></playerqueue>

@endif


@endsection
