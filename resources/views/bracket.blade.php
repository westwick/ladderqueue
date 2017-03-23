@extends('layouts.app')

@section('content')
    <section class="row main-top-padder">
        <div class="small-12 columns">
            <div class="panel">
                <h3>{{$bracket->name}}</h3>
                <p>Status: {{ $bracket->status_display() }}</p>
                <p>Registration closes:
                    {{ $bracket->start_time->addHours(-1)->diffForHumans() }}
                    ({{$bracket->start_time->addHours(-1)->toDateTimeString()}}) </p>
                <p>Prize Pool: {{$bracket->prize_pool}}</p>
                @if(Auth::user())
                {{--<a href="" class="button">Enter this tournament</a>--}}
                <form method="post" action="/start-bracket-registration" id="bracket-registration"/>
                    {{ csrf_field() }}
                    <teamselecter :teams="{{ Auth::user()->captainTeams() }}" :userid="{{ Auth::user()->id }}"></teamselecter>
                    <input type="hidden" name="bracketid" value="{{ $bracket->id }}" />
                </form>
                @else
                    <p>Log in or register to enter this tournament</p>
                @endif
            </div>
            <div class="panel">
                @foreach($teams as $team)
                    <p>{{$team->name}}</p>
                    <ul>
                        @foreach($team->members as $player)
                            <li>{{$player->name}}</li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(function() {

    })
</script>
@endsection
