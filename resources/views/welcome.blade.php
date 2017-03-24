@extends('layouts.app')

@section('head')
    <style>
        video#bgvid {
            position: absolute;
            top: -130px;
            width: 100%;
            height: auto;
            z-index: -100;
        }
        section.hero {
            background: transparent !important;
            padding: 12rem 0 10rem !important;
        }
        section.features {
            background-color: #f8f8f8;
        }
        body {
            background: #000;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -99;
            background: linear-gradient(rgba(34,36,63,0.35),rgba(34,36,63,0.35));
        }
    </style>
@endsection

@section('content')
    <section class="hero">
        <div class="hero-overlay"></div>
        <video playsinline autoplay muted loop id="bgvid">
            <source src="/images/csgo.mp4" type="video/mp4">
        </video>
        <div class="row">
            <div class="large-6 columns">
                <h4>Join the competition!</h4>
                <p class="hero-intro">Season 2 is over but it's not too late to sign up for next season! Compete against fierce teams for your chance at league glory. <a href="/season3/rules">Read the Season 3 Rules</a></p>
                <div class="button-holder">
                    <a href="/season3/registration" class="redbutton"><i class="icon ion-clipboard" style="margin-right: 9px"></i>Register For Season 3</a>
                </div>
            </div>
        </div>
    </section>

    <section class="welcome">
        <div class="row">
            <div class="medium-5 columns">
                <p class="intro">Welcome to Carbon X</p>
                <p class="welcome-text">Carbon X is an up and coming league offering a fun and competitive environment to test your skills. In our second official season, 40 teams compete for a prize pool of $700. Play against some of the best amateur teams and gain new fans, all games are broadcast on twitch, hosted by our great cast of callers. Season 2 began on Jan 16 and ends on March 12. Season 3 boasts an even bigger prize pool, learn more and sign up!</p>
            </div>
            <div class="medium-7 columns">
                <div class="row">
                    <div class="small-4 columns">
                        <img src="/images/dust2.png" class="grayscale" />
                    </div>
                    <div class="small-4 columns">
                        <img src="/images/mirage.png" class="grayscale"/>
                    </div>
                    <div class="small-4 columns">
                        <img src="/images/cache.png" class="grayscale"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <h3 class="text-center" style="margin-bottom: 2.5rem; margin-top: 0.5rem">Upcoming Games</h3>
        <div class="row">
        </div>
        <div class="row">
            <div class="small-12 columns text-center">
                <a href="/season2/schedule" class="button button-outline">View Full Schedule</a>
            </div>
        </div>
    </section>

    <section class="welcome" style="border-bottom: none">
        <h3 class="text-center" style="margin-bottom: 2.5rem; margin-top: 0.5rem">Recently Played</h3>
        <div class="row">
        </div>
        <div class="row">
            <div class="small-12 columns text-center">
                <a href="/season2/standings" class="button button-outline">View Complete Standings</a>
            </div>
        </div>
    </section>
@endsection
