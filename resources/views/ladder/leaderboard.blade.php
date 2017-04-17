@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="medium-9 large-6 medium-centered columns">
            <div class="panel ladder-leaderboard">
                <table>
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Points</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>
                                <img src="{{$player->image}}" />
                                <a href="/u/{{strtolower($player->name)}}">
                                    {{$player->name}}
                                </a>
                            </td>
                            <td>{{$player->ladder_points}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection