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
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="game in games">
                        <td><router-link :to="'/game/' + game.id">{{game.id}}</router-link></td>
                        <td>{{game.start_time}}</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
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
        }
    }
</script>
