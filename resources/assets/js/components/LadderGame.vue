<template>
    <div class="row game-status-page">
        <div class="small-12 columns">
            <div class="panel nmt text-center">
                <div class="loading" v-if="loading">
                    Loading...
                </div>
                <div v-else>
                    <div v-if="game">
                        <div v-if="game.status_id == 20 || game.status_id == 30">
                            <div class="popflash-instructionstext-center">
                                <h4>{{game.status_id == 20 ? 'Match Ready':'Match In Progress'}}</h4>
                                <p class="selected-map">Final Pick: <strong>{{game.map}}</strong></p>
                                <div class="maps-carousel">
                                    <div><img :src="'/images/' + otherMaps[0] + '.png'" /></div>
                                    <div><img :src="'/images/' + otherMaps[1] + '.png'" /></div>
                                    <div><img :src="'/images/' + otherMaps[2] + '.png'" /></div>

                                    <div class="map-selected"><img :src="'/images/' + game.map + '.png'" /></div>

                                    <div><img :src="'/images/' + otherMaps[3] + '.png'" /></div>
                                    <div><img :src="'/images/' + otherMaps[4] + '.png'" /></div>
                                    <div><img :src="'/images/' + otherMaps[5] + '.png'" /></div>
                                </div>
                                <p class="popflash-url" v-if="userInGame">
                                    URL:
                                    <a :href="'//popflash.site/scrim/' + game.url" target="_blank">
                                    http://popflash.site/scrim/{{game.url}}
                                    </a>
                                </p>
                                <p class="popflash-notes">Join the URL above to start the match. Make sure you join the correct team!</p>
                            </div>
                        </div>
                        <div v-if="game.status_id == 90">
                            <p>Match cancelled by Admin</p>
                        </div>
                        <div v-if="game.status_id == 91">
                            <p>Match cancelled - not all players accepted the ready check</p>
                        </div>
                        <div v-if="game.status_id == 40">
                            <h4>Match Complete</h4>
                            <p class="selected-map">Final Pick: {{game.map}}</p>
                            <div class="maps-carousel">
                                <div><img :src="'/images/' + otherMaps[0] + '.png'" /></div>
                                <div><img :src="'/images/' + otherMaps[1] + '.png'" /></div>
                                <div><img :src="'/images/' + otherMaps[2] + '.png'" /></div>

                                <div class="map-selected"><img :src="'/images/' + game.map + '.png'" /></div>

                                <div><img :src="'/images/' + otherMaps[3] + '.png'" /></div>
                                <div><img :src="'/images/' + otherMaps[4] + '.png'" /></div>
                                <div><img :src="'/images/' + otherMaps[5] + '.png'" /></div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p>Error: Game id {{$route.params.id}} could not be found</p>
                    </div>
                </div>
            </div>

            <div v-if="game && game.status_id == 30 && userInGame" class="row">
                <div class="small-12 columns">
                    <div class="panel text-center">
                        <div v-if="userIsCaptain">
                            <p style="margin-bottom: 2rem">The <strong>winner</strong> should enter the score below when done:</p>
                            <div class="row">
                                <div class="medium-6 columns">
                                    <p>Team 1 Score</p>
                                    <input type="number" v-model.number="team1score" />
                                </div>
                                <div class="medium-6 columns">
                                    <p>Team 2 Score</p>
                                    <input type="number" v-model.number="team2score" />
                                </div>
                            </div>
                            <button class="button" @click.prevent="submitScore">Submit Score</button>
                            <p v-if="errors" class="error">Only the winner may submit the score</p>
                        </div>
                        <div v-else>
                            <p class="waiting-for-captains">Waiting for <span>@{{team1captain.user.name}}</span> or <span>@{{team2captain.user.name}}</span> to enter the game score.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-if="game && game.status_id >= 20 && game.status_id < 40">
                <div class="medium-6 columns">
                    <div class="panel">
                        <p class="text-center"><strong>Team 1</strong></p>
                        <div v-for="player in team1players" class="player-on-team draft-player">
                            <img :src="player.user.image" />
                            {{player.user.name}} ({{player.user.ladder_points}})
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="panel">
                        <p class="text-center"><strong>Team 2</strong></p>
                        <div v-for="player in team2players" class="player-on-team draft-player">
                            <img :src="player.user.image" />
                            {{player.user.name}} ({{player.user.ladder_points}})
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-else-if="game && game.status_id == 40">
                <div class="medium-4 columns">
                    <div class="panel">
                        <p class="text-center"><strong>Team 1</strong></p>
                        <div v-for="player in team1players" class="player-on-team draft-player">
                            <img :src="player.user.image" />
                            {{player.user.name}} ({{player.user.ladder_points}})
                        </div>
                    </div>
                </div>
                <div class="medium-4 columns">
                    <div class="panel text-center">
                        <p class="score"><strong>{{game.team1score}}</strong> &mdash; <strong>{{game.team2score}}</strong></p>
                        <p>Winner: <strong>Team {{game.winner}}</strong></p>
                    </div>
                </div>
                <div class="medium-4 columns">
                    <div class="panel">
                        <p class="text-center"><strong>Team 2</strong></p>
                        <div v-for="player in team2players" class="player-on-team draft-player">
                            <img :src="player.user.image" />
                            {{player.user.name}} ({{player.user.ladder_points}})
                        </div>
                    </div>
                </div>
            </div>
            <div v-else-if="game" class="row">
                <div class="medium-6 columns medium-centered">
                    <div class="panel">
                        <div v-for="player in game.players" class="player-on-team draft-player">
                            <img :src="player.user.image" />
                            {{player.user.name}}
                            <div v-if="player.status_id === 0 || player.status_id === 91" class="ready-status notready">
                                <i class="icon ion-heart-broken"></i>
                            </div>
                            <div v-if="player.status_id === 10 || player.status_id === 92" class="ready-status ready">
                                <i class="icon ion-checkmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="isAdmin && !loading && game.status_id == 40" class="row">
                <div class="small-12 columns">
                    <div class="panel">
                        <h6>ADMIN</h6>
                        <p style="margin-bottom: 1rem;">Important: Changing this game's score will automatically adjust each players points</p>
                        <div class="row">
                            <div class="medium-6 columns">
                                <p>Team 1 Score</p>
                                <input type="number" v-model.number="team1score" />
                            </div>
                            <div class="medium-6 columns">
                                <p>Team 2 Score</p>
                                <input type="number" v-model.number="team2score" />
                            </div>
                        </div>
                        <button class="button" @click="updateScore()">Update Score</button>
                    </div>
                </div>
            </div>

            <div v-if="isAdmin && !loading && game.status_id < 40" class="row">
                <div class="small-12 columns">
                    <div class="panel">
                        <h6>Admin</h6>
                        <p><button class="button" @click="cancelGame()">Cancel Game</button></p>
                        <p>No points will be awarded for this game if cancelled</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: true,
                posting: false,
                team1score: 0,
                team2score: 0,
                game: null,
                errors: false,
                mapPool: ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train']
            }
        },
        computed: {
            userid() {
                return this.$store.state.userid
            },
            isAdmin() {
                return this.$store.state.is_admin
            },
            otherMaps() {
                if(!this.game) return this.mapPool
                var maps = this.mapPool
                return _.filter(maps, (map) => {return map !== this.game.map})
            },
            userInGame() {
                if(this.game) {
                    var player = _.find(this.game.players, {user: {id: this.userid}})
                    if(player) return true
                }
                return false
            },
            userIsTeam1Captain() {
                return this.team1captain && this.team1captain.user && this.team1captain.user.id === this.userid
            },
            userIsTeam2Captain() {
                return this.team2captain && this.team2captain.user && this.team2captain.user.id === this.userid
            },
            userIsCaptain() {
                 return this.userIsTeam1Captain || this.userIsTeam2Captain
            },
            team1players() {
                var players = _.filter(this.game.players, {team: 1})
                return _.sortBy(players, 'draft_position')
            },
            team2players() {
                var players = _.filter(this.game.players, {team: 2})
                return _.sortBy(players, 'draft_position')
            },
            team1captain() {
                return _.find(this.team1players, {isCaptain: 1})
            },
            team2captain() {
                return _.find(this.team2players, {isCaptain: 1})
            }
        },
        created() {
            this.fetchData()
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData() {
                this.loading = true
                this.$http.post('/gameinfo', {id: this.$route.params.id}).then((response) => {
                    this.loading = false
                    this.game = response.data
                    this.team1score = this.game.team1score
                    this.team2score = this.game.team2score
                }, (response) => {
                    this.loading = false
                })
            },
            submitScore() {
                if(this.validateScoreSubmission()) {
                    this.posting = true
                    var gameid = this.$route.params.id
                    var team1score = this.team1score
                    var team2score = this.team2score
                    this.$http.post('/reportscore', {gameid, team1score, team2score}).then((response) => {
                        this.posting = false
                    }, (response) => {
                        this.posting = false
                    })
                } else {
                    this.errors = true
                }
            },
            validateScoreSubmission() {
                if(this.userIsTeam1Captain && this.team1score > this.team2score) {
                    return true
                }
                else if(this.userIsTeam2Captain && this.team2score > this.team1score) {
                    return true
                } else {
                    return false
                }
            },
            updateScore() {
                if(this.isAdmin) {
                    this.posting = true
                    var gameid = this.$route.params.id
                    var team1score = this.team1score
                    var team2score = this.team2score
                    this.$http.post('/admin/updatescore', {gameid, team1score, team2score}).then((response) => {
                        this.posting = false
                        toastr.success('game score successfully updated')
                        this.$router.push('/games')
                    }, (response) => {
                        this.posting = false
                        toastr.error('something went wrong')
                    })
                }
            },
            cancelGame() {
                if(this.isAdmin) {
                    this.posting = true
                    var gameid = this.$route.params.id
                    this.$http.post('/admin/cancelgame', {gameid}).then((response) => {
                        this.posting = false
                        toastr.success('game was cancelled')
                        this.$router.push('/games/cancelled')
                    }, (resp) => {
                        //error
                    })
                }
            }
        }
    }
</script>
