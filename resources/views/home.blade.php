@extends('layouts.app')

@section('content')

<section class="row main-top-padder">
    <div class="small-12 columns">
        <div class="panel">
            @if(! Auth::user()->steam_verified)
                You must authenticate with Steam to use CarbonX.
                <a href="/steam/auth">Click here to login with Steam</a>
            @else
                Welcome!
            @endif
        </div>
    </div>
</section>
@endsection
