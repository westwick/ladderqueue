@extends('layouts.app')

@section('content')

@if(! Auth::user()->steam_verified)
    <section class="row main-top-padder padbot">
        <div class="medium-6 medium-centered columns">
            <div class="panel no-steam-auth">
                <p class="text-center">
                    You must authenticate with Steam to use CarbonX.
                </p>

                <p class="text-center">
                    <a href="/steam/auth"><img src="/images/steam-signin.png" /></a>
                </p>
            </div>
        </div>
    </section>
@else
    <section class="row main-top-padder padbot">
        <div class="medium-3 columns">
            <div class="user-sidebar">
                <div class="panel">
                    <img src="{{ Auth::user()->image }}" class="user-image" />
                    <div class="user-name">{{Auth::user()->name}}</div>
                    <div class="steam-verified"><i class="icon ion-checkmark"></i> Steam Verified</div>
                </div>


                    @if(Auth::user()->team)
                    <div class="panel team-info">
                        <img src="{{Auth::user()->team->logo}}" />
                        <p class="team-name">{{Auth::user()->team->name}}</p>
                        <p class="nomargin"><a href="/team/{{Auth::user()->team->slug}}">View team profile</a></p>
                    </div>
                    @else
                        <div class="panel">
                            <p>You aren't on a team</p>
                            <p><a href="/create-team" class="button primary button-full">Create a Team</a></p>
                            <p class="nomargin"><a href="/teams" class="button primary button-full nomargin">Join a Team</a></p>
                        </div>
                    @endif

            </div>
        </div>
        <div class="medium-9 columns">
            <div class="panel">
                <p class="biggertext">Season 3 Registration</p>
                @if(Auth::user()->team)
                    @if($seasonregistration)
                        @if(!$seasonregistration->paid)
                            <div>
                                <p>Your team needs to pay: <a href="/checkout">click here</a></p>
                            </div>
                        @endif
                        <div class="registration-status">
                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="appstatus">
                                      <p class="nomargin">Application Status: {{$seasonregistration->getStatusString()}}</p>
                                      <p class="nomargin">Payment Status: {{ $seasonregistration->paid ? 'Paid':'Not Paid'}}</p>
                                      <p class="nomargin">Division: Unassigned</p>
                                    </div>
                                </div>
                                <div class="medium-6 columns">
                                    <p>Settings:</p>
                                    <ul>
                                        <li>Server Preference: {{ $seasonregistration->server_preference }}</li>
                                        <li>Timezone: {{ $seasonregistration->team_time_zone }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="greytext nomargin">No application found. <a href="/season3/registration">Register for Season 3 Here</a></p>
                    @endif
                @else
                    <p class="greytext nomargin">You must be on a team to register for season 3</p>
                @endif
            </div>

            <div class="panel">
                <p>Upcoming Games</p>
                <div class="empty-state">
                    Available when Season 3 starts
                </div>
            </div>

            <div class="panel">
                <p>Recent Games</p>
                <div class="empty-state">
                    Available when Season 3 starts
                </div>
            </div>
        </div>
    </section>
@endif


@endsection
