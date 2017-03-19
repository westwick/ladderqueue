@extends('layouts.app')

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-12 medium-centered">
            <div class="panel season3-rules">
                <h2 class="text-center">Carbon X League CSGO Season 3 Rules</h2>

                <h3>1. Schedule &amp; Dates</h3>
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

                <h3>2. Entry and Registration</h3>
                <p>To apply for season 3, click here. (Website Registration coming soon)</p>
                <ul>
                    <li>Entry Fee</li>
                    <ul>
                        <li>Due April 18</li>
                        <li>Each team must pay an entry fee:</li>
                        <ul>
                            <li>$30 Paypal: wearwolf1@verizon.net</li>
                            <li>$40 Steam: https://steamcommunity.com/tradeoffer/new/?partner=168000790&token=mnQx-J2u</li>
                        </ul>
                        <li>The Entry Fee goes towards the Prize Pool, Website Upkeep, Server Upkeep, Ebot Costs, and Staff.</li>
                        <li>Once a team pays their entry fee they can play with a max of 5 starters and a coach.</li>
                    </ul>
                </ul>

                <h3>3. Requirements</h3>
                <ul>
                    <li>Team Requirements</li>
                    <ul>
                        <li>Teams must create a registered and approved roster consisting of 5 players, 1 free sub and a coach</li>
                        <li>Once any league game is played, the 5 man main roster is locked, and cannot be changed, unless he or she gets banned by the league, quits, or departs with the team.</li>
                    </ul>
                    <li>Player Requirements</li>
                    <ul>
                        <li>Must be from NA Region</li>
                        <li>Must play all league games under their registered account</li>
                        <li>Must follow all CarbonX General Rules</li>
                    </ul>
                </ul>

                <h3>4. Format</h3>
                <ul>
                    <li>There will be 64 teams participating in a group stage / round robin format</li>
                    <li>Teams will be split into divisions of 8 and will play each team in their division twice</li>
                    <li>All games in the regular season will be a BO1 format</li>
                    <ul>
                        <li>Map Pool: Mirage, Cache, Overpass, Cobblestone, Train, Nuke, and Inferno</li>
                        <li>Teams will alternate map bans starting with the home team. The last map left unbanned is played.</li>
                    </ul>
                    <li>Standings are determined by Wins, OT Losses, Losses, and Rounds Won Percentage</li>
                    <ul>
                        <li>Each map win earns 3 points. In overtime the losing team also gets 1 point.</li>
                        <li>Rounds Won Percentage is calculated by total rounds won divided by total rounds played, not counting rounds won or lost in forfeited games.</li>
                    </ul>
                </ul>

                <h3>5. Playoffs</h3>
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
        </div>
    </section>
@endsection
