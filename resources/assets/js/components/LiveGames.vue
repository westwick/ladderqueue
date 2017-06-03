<template>
    <div class="row">
        <div class="small-12 columns">
            <template v-if="games.length == 0">
                <div class="panel blank-state nmt">
                    No games currently in progress
                </div>
            </template>
            <template v-else>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Started</th>
                        <th>Team 1</th>
                        <th></th>
                        <th>Team 2</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="game in games">
                        <td><router-link :to="'/game/' + game.id">{{game.id}}</router-link></td>
                        <td>{{getStartedTime(game)}}</td>
                        <td>{{game.players[0].user.name}}</td>
                        <td>vs</td>
                        <td>{{game.players[1].user.name}}</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
    import moment from 'moment'
    export default {
        data() {
            return {
                //games: null
            }
        },
        computed: {
            games() {
                return this.$store.state.games
            }
        },
        methods: {
            getStartedTime(game) {
                if(game) {
                    var start = new moment(game.created_at)
                    return start.fromNow();
                }
                return 'n/a'
            }
        }
    }
</script>
