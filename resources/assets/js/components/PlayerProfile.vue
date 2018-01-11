<template>
    <div>
        <div class="loading" v-if="loading">
            <div class="loader-spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
        <div v-else class="row player-profile">
            <div class="small-12 columns">
                <div v-if="player" class="">
                    <div class="panel nmt">
                        <div class="player-head">
                            <div class="player-box">
                                <img :src="player.image"/>
                                <div class="player-name">
                                    {{player.name}}
                                    <a :href="'http://steamcommunity.com/profiles/' + player.steamid64" target="_blank">
                                        Steam Profile
                                        <i class="icon ion-android-open"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="player-stats">
                                <div class="stat-box">
                                    {{player.rank}}
                                    <span>Rank</span>
                                </div>
                                <div class="stat-box">
                                    {{player.ladder_points}}
                                    <span>Points</span>
                                </div>
                                <div class="stat-box">
                                    {{player.wins}} - {{player.losses}}
                                    <span>Record</span>
                                </div>
                                <div class="stat-box">
                                    {{player.win_pct}}
                                    <span>Win %</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="medium-4 columns">
                                <p v-if="player.intro" class="player-intro">{{player.intro}}</p>
                                <ul>
                                    <li v-if="player.is_admin" class="adminclass">
                                        <i class="icon ion-flash"></i><span>Admin</span>
                                    </li>
                                    <li v-if="player.location">
                                        <i class="icon ion-location"></i><span>{{player.location}}</span>
                                    </li>
                                    <li v-else>
                                        <i class="icon ion-android-globe"></i><span>{{player.timezone}} timezone</span>
                                    </li>
                                    <li v-if="player.age">
                                        <i class="icon ion-android-calendar"></i><span>{{player.age}} years old</span>
                                    </li>
                                    <li>
                                        <i class="icon ion-android-time"></i><span>Member since {{player.member_since}}</span>
                                    </li>
                                    <li v-if="player.twitter">
                                        <i class="icon ion-social-twitter"></i>
                                    <span>
                                        <a :href="'http://twitter.com/' + player.twitter" target="_blank">@{{player.twitter}}</a>
                                    </span>
                                    </li>
                                    <li v-if="player.twitch">
                                        <i class="icon ion-social-twitch"></i>
                                    <span>
                                        <a :href="'http://twitch.tv/' + player.twitch" target="_blank">twitch.tv/{{player.twitch}}</a>
                                    </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="medium-4 columns">
                                <div class="trophy-case" v-if="player.s5_games_played == 0">
                                    No Season 5 Stats
                                </div>
                                <div v-else class="text-center">
                                    <h4>Last Season</h4>
                                    <p>Rank: {{player.s5_rank}}</p>
                                    <p>Points: {{player.s5_points}}</p>
                                    <p>Record: {{player.s5_wins}} - {{player.s5_losses}}</p>
                                </div>
                            </div>
                            <div class="medium-4 columns">
                                <div class="trophy-case">No Badges Or Trophies To Display</div>
                            </div>
                        </div>
                    </div>
                    <div class="player-body">
                        <div class="row text-center">
                            <div class="medium-6 columns">
                                <div class="">
                                    <h4>Game History</h4>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Result</th>
                                            <th>Score</th>
                                            <th>When</th>
                                            <th>ID</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="game in player.games">
                                            <td>
                                                <template v-if="game.won">
                                                    <span class="points-positive">
                                                        W
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    <span class="points-negative">
                                                        L
                                                    </span>
                                                </template>
                                            </td>
                                            <td>
                                                {{game.score}}
                                            </td>
                                            <td>
                                                {{game.when}}
                                            </td>
                                            <td>
                                                <router-link :to="'/game/' + game.id">{{game.id}}</router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="blank-state dark-bordered" v-if="player.games.length === 0">
                                        No Game History
                                    </div>
                                </div>
                            </div>
                            <div class="medium-6 columns">
                                <div class="">
                                    <h4>Point History</h4>
                                    <table class="player-points-table">
                                        <thead>
                                        <tr>
                                            <th>Points</th>
                                            <th>Memo</th>
                                            <th>When</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in player.log">
                                            <td>
                                                <template v-if="item.points > 0">
                                                    <span class="points-positive">
                                                        +{{item.points}}
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    <span class="points-negative">
                                                        {{item.points}}
                                                    </span>
                                                </template>
                                            </td>
                                            <td>{{item.memo}}</td>
                                            <td>{{item.time_ago}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="blank-state dark-bordered" v-if="player.log.length === 0">
                                        No Point History
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="panel nmt text-center">
                    <p>Error: player {{username}} not found</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['username'],
        data() {
            return {
                loading: true,
                player: '',
                error: false
            }
        },
        methods: {
            fetchData() {
                this.loading = true
                this.$http.get('/api/user', {params: {name: this.username}}).then((response) => {
                    this.loading = false
                    this.player = response.data
                }, (response) => {
                    this.error = true
                    this.loading = false
                })
            }
        },
        created() {
            this.fetchData()
        },
        watch: {
            '$route': 'fetchData'
        }
    }
</script>
