@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="darkwrap">

        </div>
        <div class="paraa">
            {{--<img src="/images/homepage.png" />    --}}
        </div>
        <div class="row">
            <div class="medium-10 large-7 columns medium-centered text-center hero-content">
                <h4>INTRODUCING CONTINENTAL ESPORTS</h4>
                {{--<p class="hero-intro">North America's Premier Amateur Global Offensive League</p>--}}
                <p class="hero-more">North America's Premier Amateur Global Offensive League. Compete in our League, Tournaments or Ladder to prizes and cash! Do you have what it takes?</p>
                <div class="button-holder">
                    <a href="/register" class="home-cta-button">Create an Account</a>
                </div>
            </div>
        </div>
    </section>

    {{--<section class="welcome">--}}
        {{--<div class="row">--}}
            {{--<div class="medium-5 columns">--}}
                {{--<p class="intro">Welcome to Carbon X</p>--}}
                {{--<p class="welcome-text">Carbon X is an up and coming league offering a fun and competitive environment to test your skills. In our second official season, 40 teams compete for a prize pool of $700. Play against some of the best amateur teams and gain new fans, all games are broadcast on twitch, hosted by our great cast of callers. Season 2 began on Jan 16 and ends on March 12. Season 3 boasts an even bigger prize pool, learn more and sign up!</p>--}}
            {{--</div>--}}
            {{--<div class="medium-7 columns">--}}
                {{--<div class="row">--}}
                    {{--<div class="small-4 columns">--}}
                        {{--<img src="/images/dust2.png" class="grayscale" />--}}
                    {{--</div>--}}
                    {{--<div class="small-4 columns">--}}
                        {{--<img src="/images/mirage.png" class="grayscale"/>--}}
                    {{--</div>--}}
                    {{--<div class="small-4 columns">--}}
                        {{--<img src="/images/cache.png" class="grayscale"/>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    {{--<section class="features">--}}
        {{--<h3 class="text-center" style="margin-bottom: 2.5rem; margin-top: 0.5rem">Upcoming Games</h3>--}}
        {{--<div class="row">--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="small-12 columns text-center">--}}
                {{--<a href="/season2/schedule" class="button button-outline">View Full Schedule</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    <section class="home-section">
        <h3>Our first official season is underway!</h3>
        <div class="home-content-pad">
            <div class="row">
                <div class="medium-5 medium-offset-1 columns text-center">
                    <img src="/images/csgoct.png" />
                </div>
                <div class="medium-5 end columns text-center">
                    <h5>Built by CS players for CS players</h5>
                    <p>Join the league and show us what you can do. Can you take home the victory?</p>

                    <h5>$250 Prize Pool for Season 1</h5>
                    <p>Constantly changing prize pools allow you to play for something more than fun.</p>

                    <h5>Most games will be streamed and cast for your viewing pleasure</h5>
                    <p>Watch your friends play live on twitch or rewatch the your own game after the action.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="home-callout">
        <div class="parallax-section home-callout-2">

        </div>
        <h3>The next evolution in North American eSports</h3>
    </section>

    <section class="home-section">
        <h3>Choose from our 3 game modes</h3>
        <div class="row">
            <div class="medium-6 columns medium-centered">
                <p class="text-center">Continental offers three competitive game modes giving you flexibility in how you want to practice and compete. We strive to provide a competitive environment in all of our offerings. Play in just one or all three!</p>
            </div>
        </div>
        <div class="home-content-horizontal">
            <div class="row">
                <div class="medium-4 columns text-center">
                    <img src="https://placehold.it/175x140" />
                    <h5>Continental League</h5>
                    <p>Our most competitive mode and open only to teams. Pay to enter this month long season and compete for cash prizes and tune in to view games live!</p>
                    <a class="button button-outline">More Info</a>
                </div>
                <div class="medium-4 columns text-center">
                    <img src="https://placehold.it/175x140" />
                    <h5>Tournaments</h5>
                    <p>Continental also provides smaller infrequent tournaments, ranging from week long tourneys to 8-team quick play brackets.</p>
                    <a class="button button-outline">View Tournaments</a>
                </div>
                <div class="medium-4 columns text-center">
                    <img src="https://placehold.it/175x140" />
                    <h5>Continental Ladder</h5>
                    <p>Queue against other Continental players in a competitive 10-man environment. Cheap to enter, can you rise to the top of the ladder?</p>
                    <a class="button button-outline">Join the Ladder</a>
                </div>
            </div>
        </div>
    </section>

    <section class="home-callout">
        <div class="parallax-section home-callout-1">

        </div>
        <h3>A community of fun players</h3>
    </section>

    <section class="home-section">
        <h3>Our community sets us apart</h3>
        <div class="home-content-horizontal">

            <div class="row">
                <div class="medium-5 medium-offset-1 columns text-center">
                    <h5>Find a Teammate or Ringer</h5>
                    <p style="padding: 0 3rem">Need to find the perfect 5th member to fill our your roster? Or maybe just a backup, or ringer for your next match? Use our player finder</p>
                    <a class="button button-outline">Find A Player</a>
                </div>
                <div class="medium-5 columns end text-center">
                    <h5>Find a Team to compete with</h5>
                    <p style="padding: 0 3rem">The best place to find a team or club for the next Continental is right here! Check out our open teams that are looking to fill a roster spot.</p>
                    <a class="button button-outline">Open Teams</a>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section home-section-alt">
        <h3>Recent League Games</h3>
        <div class="gradient-divider"></div>
        <div class="row">
            @foreach($recent as $game)
                <div class="medium-4 columns">
                    <div class="upcoming-game">
                        <img src="/images/{{$game->map !== 'tbd' ? $game->map : 'dust2'}}.png" class="grayscale" />
                        <div class="game-teams">
                            <p class="team1">
                                <img src="{{$game->team1->logo}}" />
                                {{$game->team1->name}}
                            </p>
                            <p class="vs">{{$game->team1_score}} - {{$game->team2_score}}</p>
                            <p class="team2">
                                {{$game->team2->name}}
                                <img src="{{$game->team2->logo}}" />
                            </p>
                        </div>
                    </div>
                    <p class="upcoming-game-time">{{$game->start_time->setTimezone('America/New_York')->format('l M jS @ g:i a')}}</p>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="small-12 columns text-center">
                <a href="/season2/standings" class="button button-outline">View League Standings</a>
            </div>
        </div>
    </section>
@endsection
