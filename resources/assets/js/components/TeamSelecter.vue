<template>
    <div class="team-selecter">
        <p>Assemble your team:</p>
        <div v-for="team in teams" class="team-container">
            <div @click="selectTeam(team.id)" class="team-name" :class="{active: team.id == selectedTeamId}">{{ team.name }}</div>
            <div v-show="team.id == selectedTeamId">
                <div v-for="player in team.members" class="player-selecter">
                    <span @click="selectPlayer(player.id)">
                        <i v-if="isSelected(player.id)" class="icon ion-android-checkmark-circle"></i>
                        <i v-else class="icon ion-android-radio-button-off"></i>
                        {{ player.name }}
                    </span>
                </div>
            </div>
        </div>
        <div class="buttonwrap">
            <p>Players: {{selectedPlayers.length}} / 5</p>
            <a href="#" class="button" @click="submitForm()" :class="{ disabled: this.selectedPlayers.length !== 5}">Continue</a>
        </div>
        <input type="hidden" name="teamid" :value="selectedTeamId" />
        <input type="hidden" name="playerids" :value="selectedPlayers" />
    </div>
</template>

<script>
    var _ = require('lodash')

    export default {
        props: ['teams', 'userid'],
        data() {
            return {
                selectedTeamId: '',
                selectedPlayers: [this.userid]
            }
        },
        methods: {
            selectTeam: function(teamid) {
                this.selectedPlayers = [this.userid]
                this.selectedTeamId = teamid
            },
            selectPlayer: function(playerid) {
                // cant unselect yourself
                if(playerid === this.userid) {
                    toastr.warning("You can't unselect yourself")
                    return false
                }

                // check if its already selected
                if(_.indexOf(this.selectedPlayers, playerid) >= 0) {
                    this.selectedPlayers = this.selectedPlayers.filter((v) => v != playerid)
                } else {
                    if (this.selectedPlayers.length === 5) {
                        toastr.warning("You already have 5 players selected")
                        return false
                    }
                    this.selectedPlayers.push(playerid)
                }
            },
            isSelected: function(playerid) {
                return _.indexOf(this.selectedPlayers, playerid) >= 0
            },
            submitForm: function() {
                document.forms['bracket-registration'].submit()
            }
        }
    }
</script>
