@extends('layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endsection

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-6 medium-centered">
            <div class="panel padbot">
                <h4 class="text-center">Report Score</h4>
                <p>Game for {{ $game->start_time->format('M d Y') }} on map {{$game->map}}</p>
                <form method="post" action="/edit-game">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="medium-6 columns">
                            Team 1: <strong>{{ $game->team1->name }}</strong>
                        </div>
                        <div class="medium-6 columns">
                            Team 2: <strong>{{ $game->team2->name }}</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <input type="text" name="team1score" placeholder="0" @if($game->status !== 0)value="{{$game->team1_score}}"@endif/>
                        </div>
                        <div class="medium-6 columns">
                            <input type="text" name="team2score" placeholder="0" @if($game->status !== 0)value="{{$game->team2_score}}"@endif/>
                        </div>
                    </div>
                    <input type="hidden" name="gameid" value="{{$game->id}}" />

                    <button type="submit" class="button button-full">Update</button>
                    <input type="checkbox" name="forfeit" @if($game->status == 9)checked="checked"@endif /> Forfeit
                </form>
            </div>
            <div class="panel">
                <p>Other</p>
                <form method="post" action="/delete-game">
                    {{ csrf_field() }}
                    <input type="hidden" name="gameid" value="{{$game->id}}" />
                    <p><button type="submit" class="button secondary"><i class="icon ion-trash-a"></i> Delete Game</button></p>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/moment.js"></script>
    <script src="/js/pikaday/pikaday.js"></script>
    <script>
        var picker = new Pikaday({
            field: document.getElementById('datepicker'),
            format: 'YYYY-MM-DD'
        });

        @if (session()->has('thedate'))
            picker.setDate('{{Session::get('thedate')}}')
        @endif
    </script>
    <script type="text/javascript">
        $('select').select2();
    </script>
@endsection
