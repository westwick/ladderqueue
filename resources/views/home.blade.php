@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(! Auth::user()->steam_verified)
                        You must authenticate with Steam to use CarbonX.
                        <a href="/steam/auth">Click here to login with Steam</a>
                    @else
                        Welcome!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
