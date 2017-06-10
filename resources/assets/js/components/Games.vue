<template>
    <div class="loading" v-if="loading">
        <div class="loader-spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="small-12 columns">
                <div class="games-filter">
                    <p class="text-right">
                        <template v-if="$route.name == 'Games'">
                            <router-link to="/games/cancelled">Show Cancelled Games</router-link>
                        </template>
                        <template v-else>
                            <router-link to="/games">Show Completed Games</router-link>
                        </template>
                    </p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Started</th>
                            <th>Ended</th>
                            <th>Map</th>
                            <th width="15%">Team 1</th>
                            <th></th>
                            <th width="15%">Team 2</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="game in games">
                            <td><router-link :to="'/game/' + game.id">{{game.id}}</router-link></td>
                            <td>{{game.start_time}}</td>
                            <td>{{game.end_time}}</td>
                            <td class="mapname">{{game.map}}</td>
                            <td>
                                <span class="game-captain" :class="game.winner == 1 ? 'game-winner': ''">
                                    {{game.players[0].user.name}}
                                    <span class="game-score">{{game.team1score}}</span>
                                </span>
                            </td>
                            <td>vs</td>
                            <td>
                                <span class="game-captain" :class="game.winner == 2 ? 'game-winner': ''">
                                    {{game.players[1].user.name}}
                                    <span class="game-score">{{game.team2score}}</span>
                                </span>
                            </td>
                            <td v-html="gameStatus(game.status_id)"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="blank-state dark-bordered" v-if="games.length === 0">
                    No Games have been played
                </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: true,
                games: null
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
                var cancelled = this.$route.name !== 'Games'
                this.$http.post('/games', {cancelled}).then((response) => {
                    this.loading = false
                    this.games = response.data
                }, (response) => {
                    this.loading = false
                })
            },
            gameStatus(id) {
                if(id == 40) {
                    return '<span class="game-complete">Completed</span>'
                }
                if(id == 90) {
                    return '<span class="game-cancelled">Cancelled by Admin</span>'
                }
                if(id == 91) {
                    return '<span class="game-cancelled">Ready Check Failed</span>'
                }
            }
        }
    }
</script>
