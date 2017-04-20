@extends('layouts.app')

@section('head')
    <style>
        ul ul {
            list-style-type: circle;
        }

        .season3-rules li {
            padding-bottom: 0.25rem;
        }
    </style>
@endsection

@section('content')
    <section class="season3-hero">
        {{--<img src="/images/season3hero.png" />--}}
    </section>
    <section class="season3-nav">
        <div class="row">
            <div class="small-12 medium-12 medium-centered columns">
                <ul>
                    <li><a id="nav_0" href="#schedule" class="active">Schedule</a></li>
                    <li><a id="nav_1" href="#entry">Entry and Prizes</a></li>
                    <li><a id="nav_2" href="#requirements">Requirements</a></li>
                    <li><a id="nav_3" href="#format">Format</a></li>
                    <li><a id="nav_3" href="#games">Games</a></li>
                    <li><a id="nav_4" href="#playoffs">Playoffs</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="row padbot pagecontent">
        <div class="medium-9 columns">
            <div class="panel season3-rules">
                <a name="schedule" class="internal-link"></a>
                <h4>1. Schedule &amp; Dates</h4>
                <ul>
                    <li>Preseason</li>
                    <ul>
                        <li>April 24 - 30</li>
                    </ul>
                    <li>Regular Season</li>
                    <ul>
                        <li>Week 1: May 1 - 7</li>
                        <li>Week 2: May 8 - 14</li>
                        <li>Week 3: May 15 - 21</li>
                        <li>Week 4: May 22 - 28</li>
                    </ul>
                    <li>Playoffs</li>
                    <ul>
                        <li>Round of 32: May 29 - June 4</li>
                        <li>Round of 16: June 5 - June 11</li>
                        <li>Quarter-Finals: June 12 - 16</li>
                        <li>Semi-Finals: June 17</li>
                        <li>Finals: June 18</li>
                    </ul>
                </ul>
            </div>
            <div class="panel season3-rules">
                <a name="entry" class="internal-link"></a>
                <h4>2. Entry and Prize Pool</h4>
                <p>To apply for season 3, <a href="/season3/registration">click here</a>.</p>
                <ul>
                    <li>Entry Fee</li>
                    <ul>
                        <li>Each team must pay an entry fee of $30</li>
                        <li>Due April 18</li>
                        <li>The Entry Fee goes towards the Prize Pool, Website Upkeep, Server Upkeep, Ebot Costs, and Staff.</li>
                    </ul>
                    <li>Prize Pool</li>
                    <ul>
                        <li>1st place: $500</li>
                        <li>2nd place: $250</li>
                        <li>3rd and 4th: $125 each</li>
                        <li>5th - 8th: $50 each</li>
                    </ul>
                </ul>
            </div>
            <div class="panel season3-rules">
                <a name="requirements" class="internal-link"></a>
                <h4>3. Requirements</h4>
                <ul>
                    <li>Team leaders are in control of every aspect of the team. Team Leaders have the right to edit team information, add or remove members on the team, schedule matches, report scores, and file disputes. Every team is required to have a Team Leader.</li>
                    <li>Team Requirements</li>
                    <ul>
                        <li>Teams must create a registered and approved roster consisting of 5 players, 1 optional sub and an optional coach</li>
                        <li>There is a $5 fee to add a player to your roster after the deadline</li>
                        <li>Teams must maintain a core roster of 3 players</li>
                    </ul>
                    <li>Player Requirements</li>
                    <ul>
                        <li>Must be from NA Region</li>
                        <li>Must play all league games under their registered account</li>
                        <li>Must use an anti-cheat client for all games</li>
                        <li>Must follow all CarbonX General Rules and abide by our <a href="/code-of-conduct">code of conduct</a></li>
                    </ul>
                </ul>
            </div>
            <div class="panel season3-rules">
                <a name="format" class="internal-link"></a>
                <h4>4. Format</h4>
                <ul>
                    <li>There will be 64 teams participating in a group stage / round robin format</li>
                    <li>Teams will be split into divisions of 8 and will play each team in their division twice</li>
                    <li>Standings are determined by Wins, OT Losses, Losses, and Rounds Won Percentage</li>
                    <ul>
                        <li>Each map win earns 3 points. In overtime the losing team also gets 1 point.</li>
                        <li>Rounds Won Percentage is calculated by total rounds won divided by total rounds played, not counting rounds won or lost in forfeited games.</li>
                    </ul>
                    <li>Teams have 10 minutes from their scheduled start time to arrive in the server or will otherwise forfeit the match</li>
                    <li>Scheduling Games</li>
                    <ul>
                        <li>Upon registering, you will be asked to select the times your team is available to play</li>
                        <li>CarbonX will schedule your games according to your selected availability</li>
                        <li>Teams can reschedule any regular season match as needed if the new match time is mutually agreed upon by both team leaders</li>
                    </ul>
                </ul>
            </div>
            <div class="panel season3-rules">
                <a name="games" class="internal-link"></a>
                <h4>5. Games</h4>
                <ul>
                    <li>All games in the regular season will be a BO1 format</li>
                    <ul>
                        <li>Map Pool: Mirage, Cache, Overpass, Cobblestone, Train, Nuke, and Inferno</li>
                        <li>Teams will alternate map bans starting with the home team; the last map left unbanned is played</li>
                    </ul>
                    <li>Servers</li>
                    <ul>
                        <li>CarbonX will provide all servers</li>
                        <li>128 tick</li>
                        <li>Choose East (New York) or West (San Francisco) when signing up</li>
                        <li>VAC secured</li>
                        <li>Additional anti-cheat measures in place</li>
                    </ul>
                    <li><strong>Most</strong> games will be broadcast</li>
                    <ul>
                        <li>Stream A: https://www.twitch.tv/carbonx_tv</li>
                        <li>Stream B: https://www.twitch.tv/carbonx_tv2</li>
                    </ul>
                    <li>Coaches are allowed (sv_coaching enabled)</li>
                    <li>Overtime</li>
                    <ul>
                        <li>No ties are allowed</li>
                        <li>Overtime format is best of 6 rounds</li>
                        <li>$10k starting money</li>
                    </ul>
                    <li>Players can be changed at any time during a live  match, with a paid and registered sub only</li>
                    <li>Games may be paused but a team may not exceed 10 minutes total of pause time</li>
                </ul>
            </div>
            <div class="panel season3-rules">
                <a name="playoffs" class="internal-link"></a>
                <h4>6. Playoffs</h4>
                <ul>
                    <li>24 Teams in Playoffs</li>
                    <li>Top 3 teams from each division</li>
                    <li>Seeding / standings outlined in Section 4</li>
                    <li>Playoffs are played in a bracket, with the top team from each division receiving a first round bye</li>
                    <li>All playoff games are BO3 with the following format</li>
                    <ul>
                        <li>Home team bans, Away team bans</li>
                        <li>Home team picks a map for game 1, Away team picks a map for game 2</li>
                        <li>Home team bans again, Away team bans again</li>
                        <li>Last map left is played for game 2 (if needed)</li>
                        <li>For games 1 and 2, the team that did not pick the map gets to choose which side to start on. For the 3rd game, the Home team gets to pick which side to start on.</li>
                    </ul>
                </ul>
            </div>
            <div class="panel season3-rules">
                <h4>7. Notices</h4>
                <ul>
                    <li>We have the explicit right to change, modify, or adapt all rules as deemed correct and by Staff in order to uphold and maintain a spirit of overall fairness and good sportsmanship after getting the opinion of League Team Leaders.</li>
                    <li>The Admins and Head Admins also have the right to make judgment on matches / cases that are not specifically overall supported, or detailed in these League rules, or even goes against these rules may be taken in extreme cases, to preserve fairness and good sportsmanship.</li>
                </ul>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {

            // smooth scroll to anchors
            $('a[href*="#"]:not([href="#"])').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 200);
                        return false;
                    }
                }
            });
        })
    </script>
@endsection