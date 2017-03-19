@extends('layouts.app')

@section('content')
    <section class="player-hero">
        <div class="player-stats">
            <div class="row">
                <div class="small-12 columns text-right">
                    <div class="stat-wrap">
                        <div class="stat-inner">
                            <div class="player-stat">
                                <span class="stat-number">78</span>
                                <span class="stat-label">kills</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">89.6</span>
                                <span class="stat-label">avg dmg</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">1000</span>
                                <span class="stat-label">some stat</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">1.125</span>
                                <span class="stat-label">KDA</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">2</span>
                                <span class="stat-label">aces</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="player-info">
            <div class="row setrel">
                <div class="small-12 columns">
                    <div class="player-image">
                        <img src="/images/unknown.png" />
                    </div>
                    <div class="player-name">
                        {{$player->name}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="player-nav">
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
                    <a href="#" class="button button-secondary">Edit Profile</a>
                </div>
            </div>
        </div>
    </section>
    <section class="row padbot">
        <div class="medium-3 columns">
            <div class="panel">
                <p>Scooby Dooby Doo!</p>
                <ul class="player-details">
                    <li>
                        <i class="icon ion-ios-people"></i>
                        @if($player->team)
                        <span>
                            {{ $player->team->owner_id == $player->id ? 'Leader' : 'Member' }}
                            of
                            <a href="/team/{{$player->team->id}}">{{$player->team->name}}</a>
                        </span>
                        @else
                        <span class="noteam">Not on a team</span>
                        @endif
                    </li>
                    <li>
                        <i class="icon ion-android-globe"></i>
                        <span>US - East</span>
                    </li>
                    <li>
                        <i class="icon ion-location"></i>
                        <span>New York</span>
                    </li>
                    <li>
                        <i class="icon ion-android-calendar"></i>
                        <span>21 years old</span>
                    </li>
                </ul>
            </div>
            <div class="panel">
                <p class="panel-title">Clubs</p>
                <div class="empty-state">
                    Not a member of any clubs
                </div>
            </div>
        </div>
        <div class="medium-6 columns">
            <div class="panel">
                Player Panel - something goes here
            </div>
            <div class="panel">
                <p>Recent Matches</p>
                <div class="empty-state" style="height: 300px">
                    No matches played
                </div>
            </div>
        </div>
        <div class="medium-3 columns">
            <div class="panel">
                <p class="panel-title">Trophies</p>
                <div class="empty-state">
                    No trophies earned
                </div>
            </div>
            <div class="panel">
                <p class="panel-title">Badges</p>
                <div class="empty-state">
                    No badges to display
                </div>
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
