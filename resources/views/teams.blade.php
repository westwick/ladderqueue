@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="small-12 columns">
            <div class="panel">
                <h4 class="text-center">Teams</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Division</th>
                            <th>Owner</th>
                            <th>Members</th>
                            <th>Join</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>
                                    <img class="team-logo-small" src="{{$team->logo}}" />
                                    {{$team->name}}
                                </td>
                                @if($team->division_season2)
                                    <td>Season 2 - {{$team->division_season2}}</td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{$team->division_season2}}</td>
                                <td>{{$team->owner->name}}</td>
                                <td>{{$team->memberCount()}}/10</td>
                                <td><a href="/team/{{$team->id}}">Join this team</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
