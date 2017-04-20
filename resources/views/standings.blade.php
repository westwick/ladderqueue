@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-7 columns">
            <div class="panel">
                @foreach($divisions as $division)
                    <h4>{{$division['name']}} Group</h4>
                    <table class="standings">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Team</th>
                                <th>Points</th>
                                <th>Win</th>
                                <th>Loss</th>
                                <th>RWP <span class="tt-wrap"><i class="icon ion-information-circled tt"></i><span class="tt-text"><strong>Rounds Won Percentage</strong> - Total rounds won divided by total rounds played, not counting forfeits.</span></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($division['standings'] as $index => $standing)
                                <tr>
                                    <td width="8%" style="font-size: 1.5rem; font-weight: 300">{{ $index + 1 }}</td>
                                    <td width="50%">
                                        <img src="{{$standing->team->logo}}" />
                                        <a class="blacklink" href="/team/{{$standing->team->slug}}">{{$standing->team->name}}</a>
                                    </td>
                                    <td>{{$standing['totalpoints']}}</td>
                                    <td>{{$standing->team->wins()}}</td>
                                    <td>{{$standing->team->losses()}}</td>
                                    <td>{{$standing['rwp'] / 10}}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
        <div class="medium-5 columns">
            <div class="panel panel-dark">
                <h4>Playoff Seeding</h4>
                <table class="standings">
                    <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Team</th>
                        <th>Points</th>
                        <th>RWP <span class="tt-wrap"><i class="icon ion-information-circled tt"></i><span class="tt-text"><strong>Rounds Won Percentage</strong> - Total rounds won divided by total rounds played, not counting forfeits.</span></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($standings as $index => $standing)
                        <tr @if($index+1 <= 16)class="rowhighlight"@endif>
                            <td>
                                @if($index+1 <= 16)
                                    <strong>{{ $index + 1 }}</strong>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td>
                                <a class="blacklink" href="/team/{{$standing->team->slug}}">{{$standing->team->name}}</a>
                                <span class="tinyfont">({{$standing->team->record()}})</span>
                            </td>
                            <td>{{$standing['totalpoints']}}</td>
                            <td>{{$standing['rwp'] / 10}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
