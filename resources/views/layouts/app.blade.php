<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if($unreadCount > 0)
        [{{$unreadCount}}] -
        @endif
        Continental eSports
    </title>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/favicon-128.png" sizes="128x128" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css" />
    {{--<link href="https://fonts.googleapis.com/css?family=Patua+One|Montserrat:300,400,700" rel="stylesheet">--}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @yield('head')

</head>
<body id="main">
<div id="app">
    <header>
        <div class="not-a-row">
            <div class="small-12 columns">
                <div class="logo">
                    <a href="/"><img class="header-logo" src="/images/cel.png" /></a>
                </div>
                <ul class="mainnav">
                    <li class="active">
                        <a href="#" class="nav1-toggle nav-toggle">League</a>
                        <div class="subnav nav1-subnav">
                            <ul>
                                {{--<li class="list-section-header">Season 3</li>--}}
                                <li><a href="/season2/schedule">Schedule</a></li>
                                <li><a href="/season2/standings">Standings</a></li>
                                <li><a href="/season3">Info &amp; Rules</a></li>
                                {{--<li><a href="/season3/registration">Register</a></li>--}}
                                <li><a href="/teams">Teams</a></li>
                                {{--<li class="list-section-header inthemid">Season 2</li>--}}
                            </ul>
                        </div>
                    </li>
                    {{--<li>--}}
                        {{--<a href="#" class="nav3-toggle nav-toggle">Daily Tourneys</a>--}}
                        {{--<div class="subnav nav3-subnav">--}}
                            {{--<ul>--}}
                                {{--<li><a href="#">Rules and Info</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <li>
                        <a href="#" class="nav4-toggle nav-toggle">Community</a>
                        <div class="subnav nav4-subnav">
                            <ul>
                                <li><a href="/coming-soon">Forum</a></li>
                                <li><a href="/coming-soon">Find a Player</a></li>
                                <li><a href="/coming-soon">Find a Team</a></li>
                                <li><a href="/coming-soon">Become a Caster</a></li>
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
                        <a href="/login" id="button-login">Login</a> <a href="/register" id="button-register">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    @if(Auth::user())
    <dataloader :userstate="{{Auth::user()->getState()}}" :csrftoken="'{{csrf_token()}}'"></dataloader>
        {{--don't show party bar on party page--}}
        {{--this logic should probably go elsewhere--}}
        @if(!Request::is('assemble/*'))
            <partybar></partybar>
        @endif
    @else
    <dataloader :userstate="{ loggedIn: false, userid: null, party: {}}"></dataloader>
    @endif

    <div class="main-content">
        @yield('content')
    </div>

    <footer>
        <div class="row">
            <div class="medium-8 columns">
                <div class="row">
                    <div class="medium-3 columns">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/get-involved">Get Involved</a></li>
                            <li><a href="/announcements">Announcements</a></li>
                            <li><a href="/code-of-conduct">Code of Conduct</a></li>
                            <li><a href="/season3/rules">Season 3 Rules</a></li>
                            <li><a href="https://bitbucket.org/awestwick/cxleague/issues" target="_blank">Report a Bug</a></li>
                        </ul>
                    </div>
                    <div class="medium-3 columns">
                        <h4>Get In Touch</h4>
                        <ul>
                            <li><a href="https://www.twitch.tv/carbonx_tv" target="_blank"><i class="icon ion-social-twitch"></i> Twitch</a></li>
                            <li><a href="https://twitter.com/carbonx_league" target="_blank"><i class="icon ion-social-twitter"></i> Twitter</a></li>
                            {{--<li><a href="#"><i class="icon ion-social-facebook"></i> Facebook</a></a></li>--}}
                            <li><a href="https://www.youtube.com/channel/UCzjlYNiChADil0IPfRwaUWA" target="_blank"><i class="icon ion-social-youtube"></i> Youtube</a></li>
                            <li><a href="https://discord.gg/fshER5N" target="_blank"><i class="icon ion-ios-telephone"></i> Discord</a></li>
                        </ul>
                    </div>
                    <div class="medium-6 columns">
                        <h4>Latest News</h4>
                        <ul>
                            @foreach(App\Announcement::orderBy('created_at', 'desc')->take(3)->get() as $announcement)
                            <li><a href="/announcements">{{$announcement->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="medium-4 columns">
                <img class="footer-logo" src="/images/logocircle.png" />
                <p class="footer-about">Continental was founded in 2016 and has since grown to become an established online gaming community.  We are fueled by our love for great entertainment, and fair competition. Our talented team of employees work hard to bring our vision to life in order to create a one of a kind gaming experience for all of our clients.</p>
            </div>
        </div>
    </footer>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ asset('/js/foundation.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            toastr.options.progressBar = true
            toastr.options.positionClass = 'toast-bottom-right'

            @if (session()->has('flash_notification.message'))
                toastr.{{ session('flash_notification.level') }}('{!! session('flash_notification.message') !!}')
            @endif

        });
    </script>


@yield('scripts')

{{--<script>--}}
    {{--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
                {{--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
            {{--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
    {{--})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');--}}

    {{--ga('create', 'UA-93265405-1', 'auto');--}}
    {{--ga('send', 'pageview');--}}
{{--</script>--}}
</body>
</html>
