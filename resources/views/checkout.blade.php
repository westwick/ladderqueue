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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="{{ mix('css/app.css') }}?v=4" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @yield('head')

</head>
<body id="main">
<div>
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
                                <li><a href="/season3/registration">Register</a></li>
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
                    {{--<li>--}}
                    {{--<a href="#" class="nav3-toggle nav-toggle">Daily Tourneys</a>--}}
                    {{--<div class="subnav nav3-subnav">--}}
                    {{--<ul>--}}
                    {{--<li><a href="#">Rules and Info</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</li>--}}
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
                                <li><a href="/home"><i class="icon ion-person"></i> My Account</a></li>
                                <li><a href="/u/{{Auth::user()->name}}"><i class="icon ion-eye"></i> View Profile</a></li>
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

    <div class="main-content">
        <div class="row main-top-padder">
            <div class="medium-6 columns medium-centered">
                <div class="panel">
                    <h3 class="text-center">Season 3 Registration Payment</h3>
                    <p class="text-center" style="font-size: 1.5rem">Total Cost: $30.00</p>
                    <p><strong>Pay with Credit Card</strong></p>
                    <p>We use Stripe to process credit cards, none of your information is stored on our servers. All data is securely transmitted over https.</p>
                    <div style="display: block">
                    <form action="/complete-checkout" method="POST">
                        {{ csrf_field() }}
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ Config::get('services.stripe.key') }}"
                                data-amount="3000"
                                data-name="Carbon X League"
                                data-description="Season 3 Registration Fee"
                                data-image="https://carbonxleague.com/images/logocircle.jpg"
                                data-allow-remember-me="false"
                                data-zip-code="true"
                                data-locale="auto">
                        </script>
                    </form>
                    </div>

                    <p style="margin-top: 4rem; margin-bottom: 0"><strong>Pay with PayPal</strong></p>
                    <p class="nomargin">Send a manual payment to wearwolf1@verizon.net</p>
                    <p style="margin-top: 1rem; margin-bottom: 0"><strong>Other Payment Options</strong></p>
                    <p class="nomargin">To discuss other payment options, come chat with us on Discord.</p>
                    {{--<p style="margin-top: 4rem"><strong>Pay with PayPal</strong></p>--}}
                    {{--<p class="nomargin">Please send your paypal payment to: <strong>wearwolf1@verizon.net</strong></p>--}}
                    {{--<p style="font-size:14px">Send an email or notify us over discord so that we can mark your team as paid.</p>--}}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
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
