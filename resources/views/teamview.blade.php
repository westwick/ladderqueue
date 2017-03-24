@extends('layouts.app')

@section('content')
    <section class="teamview-hero">
        <div class="team-members">
            <div class="row">
                <div class="small-12 columns text-right">
                    <div class="players-wrap">
                        <div class="players-inner">
                            @foreach($team->players() as $player)
                            <div class="player-stat">
                                <span class="stat-number"><a href="/u/{{$player->name}}"><img src="{{$player->getImage()}}" /></a></span>
                                <span class="stat-label">{{$player->name}}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="team-info">
            <div class="row setrel">
                <div class="small-12 columns">
                    <div class="team-image">
                        <img src="{{$team->logo}}" />
                    </div>
                    <div class="player-name">
                        {{$team->name}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="teamview-nav">
        <div class="row">
            <div class="medium-9 columns">
                <ul>
                    <li><a id="nav_0" href="#schedule" class="active">Overview</a></li>
                    <li><a id="nav_1" href="#entry">Stats</a></li>
                    <li><a id="nav_2" href="#requirements">Activity</a></li>
                </ul>
            </div>
            <div class="medium-3 columns text-right">
                <div class="nav-button-flex-wrapper">
                    <a href="#" class="button nomargin show-membership-option">Join this team</a>
                </div>
            </div>
        </div>
    </section>

    <div class="row membership-option hidden">
        <div class="medium-12 columns">
            <div class="panel">
                <p><strong>Membership</strong></p>

                @if(Auth::user() && Auth::user()->team_id == NULL)
                    <form method="post" action="/join-team">
                        {{ csrf_field() }}
                        <p class="smalltext">Ask the team owner for the password</p>
                        <input type="text" name="joinpw" placeholder="password to join" />
                        <input type="hidden" name="teamid" value="{{$team->id}}" />
                        <button type="submit" class="button">Join {{$team->name}}</button>
                    </form>
                @elseif(Auth::user())
                    <p>You must leave your current team before joining a new team.</p>
                @else
                    <p>Log in to join or create a team</p>
                @endif
            </div>
        </div>
    </div>

    <section class="row padbot">
        <div class="medium-6 columns">
            <div class="panel">
                <h4 class="text-center">Upcoming Games</h4>
                @foreach($upcoming as $game)
                    <p>
                        vs {{$game->team1->name !== $team->name ? $game->team1->name : $game->team2->name}}
                        ({{$game->start_time->diffForHumans()}})
                    </p>
                @endforeach
            </div>
        </div>
        <div class="medium-6 columns">
            <div class="panel">
                <h4 class="text-center">Latest Match Results</h4>
                @foreach($recent as $game)
                    <p>
                        {{$game->winner_id == $team->id ? 'WIN' : 'LOSS'}}
                        @if($game->status == 9)
                            (F)
                        @else
                            ({{$game->team1_score}} - {{$game->team2_score}})
                        @endif
                        vs
                        <a href="/team/{{$game->team1->name !== $team->name ? $game->team1->id : $game->team2->id}}">
                            {{$game->team1->name !== $team->name ? $game->team1->name : $game->team2->name}}
                        </a>
                    </p>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.show-membership-option').click(function(e) {
            e.preventDefault();
            $('.membership-option').show();
            $(this).hide();
        })
    })
</script>
@endsection
