@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="medium-9 large-6 medium-centered columns">
            <p style="margin-top: 2rem; font-size: 14px;">The Continental Ladder is a community of players who queue against each other in a competitive 10-man environment. All teams are drafted by the captains with the highest ladder points. Compete for your share of a $100 prize. <a href="#">Learn More</a></p>
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