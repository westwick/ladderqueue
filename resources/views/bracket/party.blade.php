@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-12 medium-centered">
            <div class="panel bracket-party">
                <partylobby :partyid="{{$party->id}}" :initplayers="{{$players}}"></partylobby>
            </div>
        </div>
    </section>
@endsection
