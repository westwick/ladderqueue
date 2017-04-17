{{--<div class="borda">--}}
{{--<div style="width:100%; height: 20px; background: linear-gradient(to right, rgba(20,93,190,1) 0%,rgba(212,31,38,1) 100%);"></div>--}}
{{--</div>--}}
<div class="not-a-row">
    <div class="small-12 columns">
        <div class="logo">
            <a href="/"><img class="header-logo" src="/images/cel-logo.png" /></a>
        </div>
        <ul class="mainnav">
            <li class="active">
                <a href="#" class="nav-toggle">League <i class="icon ion-arrow-down-b"></i></a>
                <div class="subnav subnavblu">
                    <ul>
                        {{--<li class="list-section-header">Season 3</li>--}}
                        <li><a href="/season2/schedule">Schedule</a></li>
                        <li><a href="/season2/standings">Standings</a></li>
                        <li><a href="/season3">Rules &amp; Info</a></li>
                        {{--<li><a href="/season3/registration">Register</a></li>--}}
                        <li><a href="/teams">Teams</a></li>
                        {{--<li class="list-section-header inthemid">Season 2</li>--}}
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="nav-toggle">Tournaments <i class="icon ion-arrow-down-b"></i></a>
                <div class="subnav subnavblu">
                    <ul>
                        <li><a href="#">Upcoming</a></li>
                        <li><a href="#">Past Winners</a></li>
                        <li><a href="#">Rules &amp; Info</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="nav-toggle">Ladder <i class="icon ion-arrow-down-b"></i></a>
                <div class="subnav subnavblu">
                    <ul>
                        <li><a href="/ladder/queue">Queue</a></li>
                        <li><a href="/ladder/leaderboard">Leaderboard</a></li>
                        <li><a href="#">Rules &amp; Info</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="nav-toggle">Community <i class="icon ion-arrow-down-b"></i></a>
                <div class="subnav subnavblu">
                    <ul>
                        <li><a href="/coming-soon">Forum</a></li>
                        <li><a href="/coming-soon">Find a Player</a></li>
                        <li><a href="/coming-soon">Find a Team</a></li>
                        <li><a href="/coming-soon" style="font-size: 14px">Become a Caster (??)</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="login">
            @if($user)
                <div class="alerts">
                    <convonav :unreadcount="{{$unreadCount}}" :convos="{{$user->getMessages()}}"></convonav>
                </div>
                <a href="#" class="account-toggle nav-toggle">{{$user->name}} <i class="icon ion-ios-arrow-down"></i></a>

                <div class="subnav account-subnav">
                    <ul>
                        <li><a href="/home"><i class="icon ion-ios-monitor-outline"></i> Dashboard</a></li>
                        <li><a href="/u/{{strtolower(Auth::user()->name)}}"><i class="icon ion-eye"></i> View Profile</a></li>
                        <li><a href="#"><i class="icon ion-gear-a"></i> Settings</a></li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="icon ion-log-out"></i> Logout
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </ul>
                </div>

            @else
                {{--<a href="/login" id="button-login">Login</a> --}}
                {{--<a href="/register" id="button-register">Register</a>--}}
                <a href="/login" class="button" id="button-login">Login</a>
            @endif
        </div>
    </div>
</div>