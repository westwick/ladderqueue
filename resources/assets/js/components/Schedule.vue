<template>
    <div v-cloak>
        <div class="row">
            <div class="medium-6 columns">
                <p>
                    <span @click="toggleHideCompleted()" style="cursor: pointer">
                    <template v-if="hideCompleted">
                        <i class="icon ion-android-radio-button-off"></i>
                    </template>
                    <template v-else>
                        <i class="icon ion-android-checkmark-circle"></i>
                    </template>
                    Show Completed Games
                    </span>
                </p>
            </div>
            <div class="medium-6 columns text-right">
                <p >Timezone: <a href="#" class="tzdisplay blacklink">{{ tzDisplay }}</a></p>
                <select v-model="selectedTz" class="timezone-select hidden">
                    <option v-for="option in timezoneOptions" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
                <a href="#" class="timezone-select-hide hidden button button-outline button-small">close</a>
            </div>
        </div>
        <div v-if="sortedGames.length === 0">
            <div class="empty-state">
                No games to display
            </div>
        </div>
        <table class="schedule-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Team 1</th>
                <th></th>
                <th>vs</th>
                <th></th>
                <th>Team 2</th>
                <th>Event</th>
            </tr>
        </thead>
        <template v-for="day in sortedGames">
            <!--<h4>{{ day.day }}</h4>-->
            <tr v-for="game in day.games">
                <td width="20%">
                    <template v-if="game.team1_score == 0 && game.team2_score == 0">
                        <span class="tbd">{{ game.match_time_from_now }}</span>
                    </template>
                    <template v-else>
                        <template v-if="game.team1_id == game.winner_id">
                            <strong>{{ game.team1_score }}</strong>
                        </template>
                        <template v-else>
                            <template v-if="game.team1_score == 0 && game.game_status == 9">F</template>
                            <template v-else>{{ game.team1_score }}</template>
                        </template>
                        -
                        <template v-if="game.team2_id == game.winner_id">
                            <strong>{{ game.team2_score }}</strong>
                        </template>
                        <template v-else>
                            <template v-if="game.team2_score == 0 && game.game_status == 9">F</template>
                            <template v-else>{{ game.team2_score }}</template>
                        </template>
                    </template>
                </td>
                <td width="20%">
                    <a :href="'/team/' + game.team1_slug">
                        <template v-if="game.team1_id == game.winner_id">
                            <strong>{{ game.team1_name }}</strong>
                        </template>
                        <template v-else>
                            {{ game.team1_name }}
                        </template>
                    </a>
                    ({{ game.team1_record }})
                </td>
                <td width="6%">
                    <img :src="game.team1_logo" />
                </td>
                <td width="8%">
                    <template v-if="game.map == 'tbd'">
                                        <span class="tbd">
                                            tbd
                                        </span>
                    </template>
                    <template v-else>
                        {{ game.map }}
                    </template>
                </td>
                <td width="6%">
                    <img :src="game.team2_logo" />
                </td>
                <td width="25%">
                    <a :href="'/team/' + game.team2_slug">
                        <template v-if="game.team2_id == game.winner_id">
                            <strong>{{ game.team2_name }}</strong>
                        </template>
                        <template v-else>
                            {{ game.team2_name }}
                        </template>
                    </a>
                    ({{ game.team2_record }})
                </td>
                <td width="15%">Continental Week 1</td>
                <!--<td width="8%">{{ game.match_time_local }}</td>-->
                <!--<td width="12%">-->
                    <!--<a href="#" class="button button-outline button-small"><i class="icon ion-stats-bars"></i>stats</a>-->
                <!--</td>-->
            </tr>
        </template>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['games'],
        data() {
            return {
//                games: [],
                selectedTz: 'EST - Eastern Standard Time (-05:00)',
                hideCompleted: false,
                timezoneOptions: [
                    { text: 'EST - Eastern Standard Time (-05:00)', value: 'America/New_York' },
                    { text: 'CST - Central Standard Time (-06:00)', value: 'America/Chicago' },
                    { text: 'MST - Mountain Standard Time (-07:00)', value: 'America/Denver' },
                    { text: 'PST - Pacific Standard Time (-08:00)', value: 'America/Los_Angeles' }
                ]
            }
        },
        computed: {
            sortedGames: function () {
                var gamelist = []
                var currentDay = ''
                var gamelistindex = 0
                for (var i = 0; i < this.games.length; i++) {
                    if(this.hideCompleted && this.games[i].game_status > 0) continue
                    var gametime = moment.tz(this.games[i].match_time, 'Etc/UTC')
                    gametime.tz(this.selectedTz)
                    var gameday = gametime.format('dddd MMM Do')
                    var gamedata = Object.assign({
                        match_time_local: gametime.format('h:mm a'),
                        match_time_from_now: gametime.fromNow()
                    }, this.games[i])
                    if (currentDay !== gameday) {
                        gamelistindex = gamelist.push({day: gameday, games: []})
                        currentDay = gameday
                    }
                    gamelist[gamelistindex-1].games.push(gamedata)
                }

                return gamelist
            },
            tzDisplay: function () {
                var option = this.timezoneOptions.find(o => o.value == this.selectedTz)
                return option.text.substring(0,3)
            }
        },
        created: function () {
            var guesstz = moment.tz.guess()
            var nowtz = moment.tz(guesstz)
            var findtz = this.timezoneOptions.find(o => o.value == guesstz)
            if(findtz === undefined) {
                this.timezoneOptions.push({text: nowtz.format('z') + ' - ' + guesstz + ' (' + nowtz.format('Z') + ')', value: guesstz})
                this.selectedTz = guesstz
            } else {
                this.selectedTz = findtz.value
            }
        },
        methods: {
            toggleHideCompleted: function() {
                this.hideCompleted = this.hideCompleted ? false : true;
            }
        }
    }
</script>
