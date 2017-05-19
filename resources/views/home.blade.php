@extends('layouts.app')

@section('content')
<div class="main-content">
    @if(! Auth::user()->steam_verified)
        <section class="row main-top-padder padbot">
            <div class="medium-6 medium-centered columns">
                <div class="panel no-steam-auth">
                    <p class="text-center">
                        You must authenticate with Steam to use {{ config('app.name') }}.
                    </p>

                    <p class="text-center">
                        <a href="/steam/auth"><img src="/images/steam-signin.png" /></a>
                    </p>
                </div>
            </div>
        </section>
    @else
        <app :initplayers="{{$players}}" :initgame="{{ $game !== NULL ? $game : '{}' }}"></app>

        <!--
        <div class="content-area">
            <div class="content-head text-right">
                Logged in as <strong>drew</strong> &mdash; Current Rank: <strong>29</strong>
            </div>
            @if($canQueue)
                <playerqueue :initplayers="{{$players}}" :initgame="{{ $game !== NULL ? $game : '{}' }}"></playerqueue>
            @else
                <div class="row">
                    <div class="medium-9 large-6 medium-centered columns">
                        <div class="panel text-center">
                            <p>Not Confirmed for Queue (talk to admin)</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        -->
    @endif
</div>


@endsection
