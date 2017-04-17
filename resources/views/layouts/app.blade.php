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
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
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
        @include('partials.header')
    </header>

    @if(Auth::user())
        <dataloader :userstate="{{Auth::user()->getState()}}" :csrftoken="'{{csrf_token()}}'"></dataloader>
        {{--don't show party bar on party page--}}
        {{--this logic should probably go elsewhere--}}
        @if(!Request::is('assemble/*'))
            {{--<partybar></partybar>--}}
        @endif
    @else
        <dataloader :userstate="{ loggedIn: false, userid: null, party: {}}"></dataloader>
    @endif


    <div id="wrap">
        <div class="browrap">
            <div class="main-content">
                @yield('content')
            </div>

            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>
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
