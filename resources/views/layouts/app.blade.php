<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carbon X League</title>
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
    <link href="https://fonts.googleapis.com/css?family=Patua+One|Montserrat:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('css/app.css') }}?v=4" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @yield('head')

</head>
<body id="main">
<header>
    <div class="not-a-row">
        <div class="small-12 columns">
            <div class="logo">
                <a href="/"><img class="header-logo" src="/images/logo.png" /></a>
            </div>
            <ul>
                <li class="active">
                    <a href="#" class="nav1-toggle nav-toggle">Season 3</a>
                    <div class="subnav nav1-subnav">
                        <ul>
                            {{--<li class="list-section-header">Season 3</li>--}}
                            <li><a href="/season3">Overview</a></li>
                            <li><a href="/season3/rules">Rules</a></li>
                            <li><a href="https://docs.google.com/forms/d/1KVAx-Fkdw-CyXMRjF8kGMnhQPuYCzMEWYrup6cquEyY/viewform" target="_blank">Registration</a></li>
                            {{--<li class="list-section-header inthemid">Season 2</li>--}}
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="nav2-toggle nav-toggle">Season 2</a>
                    <div class="subnav nav2-subnav">
                        <ul>
                            <li><a href="/season2/standings">Standings</a></li>
                            <li><a href="/season2/schedule">Schedule</a></li>
                            <li><a href="http://challonge.com/CXS2Playoffs" target="_blank">Playoffs</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="nav3-toggle nav-toggle">Daily Tourneys</a>
                    <div class="subnav nav3-subnav">
                        <ul>
                            <li><a href="#">Rules and Info</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="nav4-toggle nav-toggle">Resources</a>
                    <div class="subnav nav4-subnav">
                        <ul>
                            <li><a href="#">Forum</a></li>
                            <li><a href="#">Find a Player</a></li>
                            <li><a href="#">Find a Team</a></li>
                            <li><a href="#">Become a Caster</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="login">
                @if(Auth::user())
                    <div class="alerts">
                        <a href="#"><i class="icon ion-email"></i></a>
                    </div>
                    <a href="#" class="account-toggle nav-toggle">{{Auth::user()->name}} <i class="icon ion-ios-arrow-down"></i></a>

                    <div class="subnav account-subnav">
                        <ul>
                            <li><a href="/account"><i class="icon ion-person"></i> My Account</a></li>
                            <li><a href="/u/{{Auth::user()->slug}}"><i class="icon ion-eye"></i> View Profile</a></li>
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

<div class="main-content" id="app">
    @yield('content')
</div>

<footer>
    <div class="row">
        <div class="medium-8 columns">
            <div class="row">
                <div class="medium-3 columns">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Get Involved</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Rules</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                    </ul>
                </div>
                <div class="medium-3 columns">
                    <h4>Get In Touch</h4>
                    <ul>
                        <li><a href="https://www.twitch.tv/carbonx_tv"><i class="icon ion-social-twitch"></i> Twitch</a></li>
                        <li><a href="#"><i class="icon ion-social-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="icon ion-social-facebook"></i> Facebook</a></a></li>
                        <li><a href="#"><i class="icon ion-social-youtube"></i> Youtube</a></a></li>
                        <li><a href="#"><i class="icon ion-social-whatsapp"></i> Discord</a></a></li>
                    </ul>
                </div>
                <div class="medium-6 columns">
                    <h4>Latest News</h4>
                    <ul>
                        <li><a href="#">Top 5 Plays of the Week for Jan 4 - Jan 11</a></li>
                        <li><a href="#">Team X beats Team Y in close 16-13 match</a></li>
                        <li><a href="#">Some news item</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="medium-4 columns">
            <img class="footer-logo" src="/images/logocircle.png" />
            <p class="footer-about">CarbonX was founded in 2016 and has since grown to become an established online gaming community.  We are fueled by our love for great entertainment, and fair competition. Our talented team of employees work hard to bring our vision to life in order to create a one of a kind gaming experience for all of our clients.</p>
        </div>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if (session()->has('flash_notification.message'))
    <script>
        $(document).ready(function() {

            toastr.options.progressBar = true
            toastr.options.positionClass = 'toast-bottom-right'

            toastr.{{ session('flash_notification.level') }}('{!! session('flash_notification.message') !!}')

        });
    </script>
@endif

@yield('scripts')

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-93265405-1', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>
