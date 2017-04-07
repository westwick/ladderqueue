@extends('layouts.app')

@section('content')
    <section class="player-hero">
        <div class="player-stats">
            <div class="row">
                <div class="small-12 columns text-right">
                    <div class="stat-wrap">
                        <div class="stat-inner">
                            <div class="player-stat">
                                <span class="stat-number">0</span>
                                <span class="stat-label">kills</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">0.0</span>
                                <span class="stat-label">avg dmg</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">999</span>
                                <span class="stat-label">clutchs</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">1.0</span>
                                <span class="stat-label">KDA</span>
                            </div>
                            <div class="player-stat">
                                <span class="stat-number">0</span>
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
                        <img src="{{ $player->avatar !== NULL ? $player->avatar : '/images/unknown.png' }}" />
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
                    @if(Auth::user())
                        @if(Auth::user()->id == $player->id)
                            <a href="#" class="button nomargin edit-profile-button">Edit Profile</a>
                        @else
                            <button class="button nomargin" data-open="exampleModal1">Send a Message</button>

                            <div class="reveal" id="exampleModal1" data-reveal data-animation-in="slide-in-down fast ease-in-out">
                                <form method="post" action="/sendmsg">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="to_user_id" value="{{$player->id}}" />
                                    <p>Send a message to {{$player->name}}</p>
                                    <textarea placeholder="Enter your message" maxlength="240" class="newmessage" name="message"></textarea>
                                    <input type="submit" class="button" value="send" />
                                </form>
                                <a class="close-button" data-close aria-label="Close modal">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="row padbot">
        <div class="medium-3 columns">
            <div class="panel edit-profile hidden">
                <form method="POST" action="/update-profile">
                    {{ csrf_field() }}
                    <textarea name="intro" style="height: 100px">{{$player->intro}}</textarea>
                    <select name="serverpreference">
                        <option value="US - East" {{ $player->server_preference === 'US - East' ? 'selected':'' }}>US - East</option>
                        <option value="US - West" {{ $player->server_preference === 'US - West' ? 'selected':'' }}>US - West</option>
                    </select>
                    <input type="text" value="{{$player->location}}" name="location" placeholder="New York, NY"/>
                    <input type="number" value="{{$player->age != 0 ? $player->age:''}}" name="age" placeholder="age" />
                    <input type="submit" class="button button-full" value="Update Profile"/>
                </form>
            </div>
            <div class="panel player-profile">
                <p style="line-height: 20px">{{$player->intro}}</p>
                <ul class="player-details">
                    <li>
                        <i class="icon ion-ios-people"></i>
                        @if($player->team)
                        <span>
                            {{ $player->team->owner_id == $player->id ? 'Leader' : 'Member' }}
                            of
                            <a href="/team/{{$player->team->slug}}">{{$player->team->name}}</a>
                        </span>
                        @else
                        <span class="noteam">Not on a team</span>
                        @endif
                    </li>
                    <li>
                        <i class="icon ion-android-globe"></i>
                        <span>{{$player->server_preference}}</span>
                    </li>
                    <li>
                        <i class="icon ion-location"></i>
                        <span>{{$player->location}}</span>
                    </li>
                    <li>
                        <i class="icon ion-android-calendar"></i>
                        <span>{{$player->age}} years old</span>
                    </li>
                    <li>
                        <i class="icon ion-steam"></i>
                        @if($player->steamid !== NULL)
                            <span>{{ substr($player->steamid, 6) }}</span>
                        @else
                            <span class="noteam">Not authenticated</span>
                        @endif
                    </li>
                </ul>
            </div>
            {{--<div class="panel">--}}
                {{--<p class="panel-title">Clubs</p>--}}
                {{--<div class="empty-state">--}}
                    {{--Not a member of any clubs--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="medium-6 columns">
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
        $('.edit-profile-button').click(function() {
            $('.edit-profile').show();
            $('.player-profile').hide();
        })
    })
</script>
@endsection
