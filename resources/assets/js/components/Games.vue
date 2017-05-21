<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="loading" v-if="loading">
                <div class="panel nmt text-center">
                    Loading...
                </div>
            </div>
            <div v-else>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Started</th>
                            <th>Ended</th>
                            <th>Team 1 Score</th>
                            <th>Team 2 Score</th>
                            <th>Winner</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="game in games">
                            <td><router-link :to="'/game/' + game.id">{{game.id}}</router-link></td>
                            <td>{{game.start_time}}</td>
                            <td>{{game.end_time}}</td>
                            <td>{{game.team1score}}</td>
                            <td>{{game.team2score}}</td>
                            <td>
                                <template v-if="game.winner >= 1">
                                    {{game.winner}}
                                </template>
                            </td>
                            <td v-html="gameStatus(game.status_id)"></td>
                        </tr>
                    </tbody>
                </table>
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
        methods: {
            fetchData() {
                this.loading = true
                this.$http.post('/games').then((response) => {
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
                if(id == 91) {
                    return '<span class="game-cancelled">Cancelled</span>'
                }
            }
        }
    }
</script>
