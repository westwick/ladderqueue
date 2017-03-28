<template>
  <div>
    <section class="queue-status main-top-padder ">
      <div class="row">
        <div class="small-12 columns">
          <div class="panel">
            <template v-if="pickTurn !== 0">
              Status: {{pickTurn.user.name}}'s turn to pick a player
            </template>
            <template v-else>
              Status: Someone's turn to ban a map
            </template>
          </div>
        </div>
      </div>
    </section>
    <section v-if="!inGame" class="row padbot">
      <div class="medium-6 columns medium-centered">
        <div class="panel text-center">
          <p class="text-center">Queue status: {{players.length}}/10 players</p>
          <div v-if="!inQueue">
            <button class="button primary" @click.disable="enterQueue" :disabled="this.loading">
                {{ !this.loading ? 'Join Queue': 'Joining...'}}
            </button>
          </div>
          <div class="players-in-queue">
            <p>Players in queue:</p>
            <p v-for="player in players">{{player.name}}</p>
          </div>
          <div v-if="inQueue">
            <button class="button primary" @click.disable="leaveQueue" :disabled="this.loading">
                {{ !this.loading ? 'Leave Queue': 'Leaving...'}}
            </button>
          </div>
        </div>
      </div>
    </section>
    <section v-else class="row padbot text-center ladder-draft">
      <div class="medium-4 columns">
        <div class="panel">
          <strong>Team 1</strong>
          <div v-for="player in team1players" class="player-on-team draft-player">
            <img :src="player.user.avatar !== null ? player.user.avatar : '/images/unknown.png'" />
            {{player.user.name}} ({{player.user.ladder_points}})
          </div>
        </div>
      </div>
      <div class="medium-4 columns">
        <div class="panel">
          <div v-if="undraftedcount > 0">
            <strong>Undrafted Players</strong>
            <div v-for="player in undraftedplayers" class="player-available draft-player">
              <img :src="player.user.avatar !== null ? player.user.avatar : '/images/unknown.png'" />
              {{player.user.name}} ({{player.user.ladder_points}})
              <div class="pick-player">
                <a href="#" class="button" @click.prevent="draftPlayer(player.user.id)" :disabled="!canDraft || this.loading">
                  {{ !this.loading ? 'Draft': 'Drafting...'}}
                </a>
              </div>
            </div>
          </div>
          <div v-else>
            <strong>Map Bans</strong>
            <div class="map-banner" v-for="map in mapPool">
              <p v-if="!mapIsBanned(map)">
                {{map}}
                <a href="#" class="button" @click.prevent="banMap(map)" :disabled="!canBanMap || this.loading">Ban</a>
              </p>
              <p v-else class="map-banned">
                {{map}}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="medium-4 columns">
        <div class="panel">
          <strong>Team 2</strong>
          <div v-for="player in team2players" class="player-on-team draft-player">
            <img :src="player.user.avatar !== null ? player.user.avatar : '/images/unknown.png'" />
            {{player.user.name}} ({{player.user.ladder_points}})
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
    var _ = require('lodash')
    export default {
        props: ['initplayers', 'initgame'],
        data() {
            return {
                players: this.initplayers,
                game: this.initgame,
                loading: false,
                inGame: true,
                mapPool: ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train']
            }
        },
        computed: {
            userid() {
              return this.$store.state.userid
            },
            inQueue() {
                var q = false
                _.forEach(this.players, (player) => {
                  if(player.id == this.userid) q = true
                })
                return q
            },
            undraftedplayers() {
              return _.filter(this.game.players, {team: 0})
            },
            undraftedcount() {
              return this.undraftedplayers.length
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
            },
            pickTurn() {
              if(this.undraftedcount === 8) return this.team1captain
              if(this.undraftedcount === 7) return this.team2captain
              if(this.undraftedcount === 6) return this.team2captain
              if(this.undraftedcount === 5) return this.team1captain
              if(this.undraftedcount === 4) return this.team2captain
              if(this.undraftedcount === 3) return this.team1captain
              if(this.undraftedcount === 2) return this.team2captain
              if(this.undraftedcount === 1) return this.team1captain
              return 0
            },
            canDraft() {
              if(this.pickTurn === 0) return false
              return this.pickTurn.user.id === this.userid
            },
            banTurn() {
              if(!this.game.map_bans) return this.team1captain
              if(this.game.map_bans.length === 0) return this.team1captain
              if(this.game.map_bans.length === 1) return this.team2captain
              if(this.game.map_bans.length === 2) return this.team1captain
              if(this.game.map_bans.length === 3) return this.team2captain
              if(this.game.map_bans.length === 4) return this.team1captain
              if(this.game.map_bans.length === 5) return this.team2captain
              return 0
            },
            canBanMap() {
              if(this.banTurn === 0) return false
              return this.banTurn.user.id === this.userid
            }
        },
        methods: {
            startPartyListener: function() {
                Echo.private('queue')
                    .listen('PlayerJoinedQueue', (e) => {
                        var p = this.players
                        p.push(e.user)
                        this.players = p
                    })
                    .listen('PlayerLeftQueue', (e) => {
                        var p = []
                        _.forEach(this.players, (player) => {
                          if(player.id !== e.user.id) {
                            p.push(player)
                          }
                        })
                        this.players = p
                    })
            },
            startGameListener: function() {
              Echo.private('laddergame.' + this.game.id)
                  .listen('PlayerDrafted', (e) => {
                      this.playerDrafted(e.player)
                  })
                  .listen('MapBanned', (e) => {
                      console.log(e)
                      this.mapBanned(e.map)
                  })
            },
            enterQueue() {
                this.loading = true
                this.$http.post('/enter-queue').then((response) => {
                    console.log(response)
                    this.loading = false
                    var p = this.players
                    p.push(response.data.user)
                    this.players = p
                }, (response) => {
                    this.loading = false
                })
            },
            leaveQueue() {
                this.loading = true
                this.$http.post('/leave-queue').then((response) => {
                    console.log(response)
                    this.loading = false
                    var p = []
                    _.forEach(this.players, (player) => {
                      if(player.id !== this.userid) {
                        p.push(player)
                      }
                    })
                    this.players = p
                }, (response) => {
                    this.loading = false
                })
            },
            draftPlayer(userId) {
              if(!this.canDraft) return false
              this.loading = true
              var gameId = this.game.id
              this.$http.post('/draft-player', {gameId, userId}).then((response) => {
                  this.playerDrafted(response.data.player)
                  this.loading = false
              }, (response) => {
                  this.loading = false
              })
            },
            playerDrafted(player) {
              var players = this.game.players
              var index = _.indexOf(players, _.find(players, {id: player.id}))
              // remove old player, insert new one
              this.game.players.splice(index, 1, player)
            },
            banMap(map) {
              this.loading = true
              var gameId = this.game.id
              this.$http.post('/ban-map', {gameId, map}).then((response) => {
                  this.mapBanned(map)
                  this.loading = false
              }, (response) => {
                  this.loading = false
              })
            },
            mapBanned(map) {
              if(this.game.map_bans) {
                this.game.map_bans.splice(0, 0, map)
              } else {
                this.game.map_bans = [map]
              }
            },
            mapIsBanned(map) {
              return this.game.map_bans && this.game.map_bans.includes(map)
            }
        },
        created: function () {
            this.startPartyListener()
            this.startGameListener()
        }
    }
</script>
