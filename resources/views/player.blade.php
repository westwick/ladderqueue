@extends('layouts.app')

@section('head')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        #container {
            height: 180px;
        }

        .trophycase {
            display: flex;
        }

        .trophy {
            text-align: center;
            font-size: 14px;
            color: #666;
            padding: 0.5rem;
        }

        .trophy i {
            display: block;
            font-size: 1.5rem;
            color: #111;
        }
    </style>
@endsection

@section('content')
    <section class="player-hero">
        <div class="player-bg"></div>
        <div class="player-stats">
            <div class="row">
                <div class="small-12 columns text-right">
                    <div class="player-hero-info">
                        @if($player->team)
                        <p class="player-info-team">
                            {{ $player->team->owner_id == $player->id ? 'Leader' : 'Member' }}
                                of
                            <a href="/team/{{$player->team->slug}}">{{$player->team->name}}</a>
                        </p>
                        @else
                            <p class="noteam">Not on a team</p>
                        @endif
                        <div class="player-info-online-status">
                            @if($player->updated_at->diffInMinutes() < 5)
                            <div class="player-online">
                                <i class="status-icon">
                                    <span class="status-icon__pulse"></span>
                                    <span class="status-icon__dot"></span>
                                </i>
                                Online
                            </div>
                            @else
                            <span class="player-offline">Last online: {{$player->updated_at->diffForHumans()}}</span>
                            @endif
                        </div>
                    </div>
                    {{--<div class="stat-wrap">--}}
                        {{--<div class="stat-inner">--}}
                            {{--<div class="player-stat">--}}
                                {{--<span class="stat-number">0</span>--}}
                                {{--<span class="stat-label">kills</span>--}}
                            {{--</div>--}}
                            {{--<div class="player-stat">--}}
                                {{--<span class="stat-number">0.0</span>--}}
                                {{--<span class="stat-label">avg dmg</span>--}}
                            {{--</div>--}}
                            {{--<div class="player-stat">--}}
                                {{--<span class="stat-number">999</span>--}}
                                {{--<span class="stat-label">clutchs</span>--}}
                            {{--</div>--}}
                            {{--<div class="player-stat">--}}
                                {{--<span class="stat-number">1.0</span>--}}
                                {{--<span class="stat-label">KDA</span>--}}
                            {{--</div>--}}
                            {{--<div class="player-stat">--}}
                                {{--<span class="stat-number">0</span>--}}
                                {{--<span class="stat-label">aces</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <div class="player-info">
            <div class="row setrel">
                <div class="small-12 columns">
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
                <div class="player-image">
                    <img src="{{ $player->image }}" />
                </div>
                <ul>
                    <li><a href="/u/{{strtolower($player->name)}}" class="active">Overview</a></li>
                    <li><a href="/u/{{strtolower($player->name)}}/activity">Activity</a></li>
                </ul>
            </div>
            <div class="medium-3 columns text-right">
                <div class="nav-button-flex-wrapper">
                    @if(Auth::user())
                        @if(Auth::user()->id == $player->id)
                            <a href="#" class="button nomargin edit-profile-button">Edit Profile</a>
                            <a href="#" class="button nomargin save-profile-button hidden">Save</a>
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
    <section class="player-main">
        <div class="row">
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
                        <input type="submit" class="button button-full update-profile-button" value="Update Profile"/>
                    </form>
                </div>
                <div class="panel player-profile">
                    <p style="line-height: 20px">{{$player->intro}}</p>
                    <ul class="player-details">
                        <li>
                            <i class="icon ion-network"></i>
                            <span>{{$player->server_preference}}</span>
                        </li>
                        @if($player->location)
                        <li>
                            <i class="icon ion-location"></i>
                            <span>{{$player->location}}</span>
                        </li>
                        @endif
                        @if($player->age >= 15)
                        <li>
                            <i class="icon ion-android-calendar"></i>
                            <span>{{$player->age}} years old</span>
                        </li>
                        @endif
                        <li>
                            <i class="icon ion-android-time"></i>
                            <span>Member since {{$player->created_at->format('M Y')}}</span>
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
                    <div id="container"></div>
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
                    <p class="text-center">Trophy Case</p>
                    <div class="trophycase">
                        <div class="trophy">
                            <i class="icon ion-trophy"></i>
                            Beta User
                        </div>
                        <div class="trophy">
                            <i class="icon ion-ribbon-a"></i>
                            Match MVP (x3)
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.edit-profile-button').click(function(e) {
            e.preventDefault()
            $('.edit-profile').show();
            $('.player-profile').hide();
            $(this).hide();
            $('.save-profile-button').show()
        })

        $('.save-profile-button').click(function(e) {
            e.preventDefault()
            $('.update-profile-button').click()
        })
    })
</script>
    <script>
        Highcharts.chart('container', {

            title: {
                text: 'KDA - last 10 games'
            },

            yAxis: {
                title: {
                    enabled: false
                }
            },
            xAxis: {
                categories: [''],
                labels: {
                    enabled: false
                }
            },
            legend: false,
            credits: false,


            series: [{
                name: 'KDA',
                data: [0.89, 0.5, 1.12, 1.54, 0.5, 0.2, 0.9, 0.2, 1.5, 1.8]
            }]

        });
    </script>
@endsection
