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
    import moment from 'moment-timezone'
    export default {
        data() {
            return {
                //games: null
            }
        },
        computed: {
            games() {
                return this.$store.state.games
            },
            userTimezone() {
                var tz = this.$store.state.settings.timezone
                if(tz === 'Eastern') return 'America/New_York'
                if(tz === 'Central') return 'America/Chicago'
                if(tz === 'Mountain') return 'America/Denver'
                if(tz === 'Pacific') return 'America/Los_Angeles'
                return 'America/New_York'
            }
        },
        methods: {
            getStartedTime(game) {
                if(game) {
                    var start_tz = moment.utc(game.created_at).tz(this.userTimezone)
                    return start_tz.fromNow()
                }
                return 'n/a'
            }
        }
    }
</script>
