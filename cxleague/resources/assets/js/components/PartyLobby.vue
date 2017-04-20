<template>
    <div>
        <h4 class="text-center">Assembling team</h4>
          <div v-if="partyPlayerStatus < 20">
            <p>
              This bracket costs 1 token to enter:
              <div v-if="enterBracketLoading">
                <button class="button disabled">Loading...</button>
              </div>
              <div v-else>
                <button class="button" @click.prevent="enterBracket()">Confirm</button>
              </div>
            </p>
          </div>
          <div v-else>
            <p v-if="allPlayersPaid">Waiting for team leader to confirm</p>
            <p v-else>Waiting for teammates...</p>
          </div>
        <div class="party-players">
          <div class="party-player" v-for="player in players">
            <img :src="player.user.avatar ? player.user.avatar:'/images/unknown.png'" />
            {{ player.user.name }} - {{getStatusString(player.status_id)}}
          </div>
        </div>
        <div class="complete-registration" v-if="userIsCreator">
          <button class="button" :class="{disabled: !allPlayersPaid}" @click="completeRegistration()">Complete Registration</button>
        </div>
    </div>
</template>

<script>
    var _ = require('lodash')
    export default {
        props: ['initplayers', 'partyid'],
        data() {
            return {
                players: this.initplayers,
                enterBracketLoading: false
            }
        },
        computed: {
            userid() {
              return this.$store.state.userid
            },
            party() {
                return this.$store.state.party
            },
            partyPlayer() {
                return _.find(this.players, {user: {id: this.userid}})
            },
            partyPlayerStatus() {
                return this.partyPlayer.status_id
            },
            allPlayersPaid() {
                var allpaid = true
                _.forEach(this.players, function(player) {
                  if(player.status_id < 20) {
                    allpaid = false
                  }
                })
                return allpaid
            },
            userIsCreator(){
              return this.party.creator.id === this.userid
            }
        },
        methods: {
            startPartyListener: function() {
                Echo.private('party.' + this.partyid)
                    .listen('PartyPlayerStatusChange', (e) => {
                        var playerid = e.player.id
                        var newstatus = e.player.status_id
                        var player = _.find(this.players, {id: playerid})
                        player.status_id = newstatus
                        console.log(player)
                    })
                    .listen('PartyDisbanded', (e) => {
                        console.log(e);
                    })
            },
            enterBracket() {
                this.enterBracketLoading = true
                this.$http.post('/enter-bracket', {partyid: this.party.id}).then((response) => {
                    this.enterBracketLoading = false
                    this.partyPlayer.status_id = 20
                }, (response) => {
                    this.enterBracketLoading = false
                })
            },
            completeRegistration() {
              console.log('hi')
            },
            getStatusString: function(id) {
              var status = ''
              switch(id) {
                case 0:
                  return 'Pending'
                  break
                case 10:
                  return 'Joined'
                  break
                case 20:
                  return 'Paid'
                  break
                case 90:
                  return 'Declined'
                  break
                default:
                  return 'Unknown'
              }
            }
        },
        created: function () {
            this.startPartyListener()
        }
    }
</script>
