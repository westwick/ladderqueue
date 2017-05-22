<template>
  <div>
    <div v-if="!allPlayersReady">
        <div class="row">
            <div class="small-12 columns text-center">
                <div v-if="userReady">
                    <div class="panel nmt">
                        <p>Waiting for other players to accept</p>
                    </div>
                </div>
                <div v-else>
                    <div class="panel nmt">
                        <h4>Match Found!</h4>
                        <p>
                            <button class="button" @click.prevent="readyCheck()" :disabled="loading">
                                {{ !loading ? 'Accept': 'Please wait...'}}
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <section class="queue-status-header main-top-padder ">
          <div class="row" v-if="inGame">
            <div class="small-12 columns">
              <div class="">
                <template v-if="pickTurn !== 0">
                  Status: <span class="player-hover">{{'@' + pickTurn.user.name}}'s</span> turn to pick a player
                </template>
                <template v-else>
                  Status: Someone's turn to ban a map
                </template>
              </div>
            </div>
          </div>
        </section>
        <section v-if="!inGame">
          <div class="row">
              <div class="small-12 columns">
                  <div class="panel text-center">
                      <h4>Game Not Detected</h4>
                      <p>Try refreshing your page and if you are still having problems, contact an admin.</p>
                  </div>
              </div>
          </div>
        </section>
        <section v-else class="row padbot text-center ladder-draft">
          <div class="medium-4 columns">
            <div class="panel">
              <strong>Team 1</strong>
              <div v-for="player in team1players" class="player-on-team draft-player">
                <img :src="player.user.image" />
                {{player.user.name}} &dash; <span class="ladderpoints">{{player.user.ladder_points}}</span>
              </div>
            </div>
          </div>
          <div class="medium-4 columns">
            <div class="panel">
              <div v-if="undraftedcount > 0">
                <strong>Undrafted Players</strong>
                <div v-for="player in undraftedplayers" class="player-available draft-player">
                  <img :src="player.user.image" />
                  {{player.user.name}} &dash; <span class="ladderpoints">{{player.user.ladder_points}}</span>
                  <div class="pick-player">
                    <a href="#" class="button" @click.prevent="draftPlayer(player.user.id)" :disabled="!canDraft || loading">
                      {{ !loading ? 'Draft': 'Drafting...'}}
                    </a>
                  </div>
                </div>
              </div>
              <div v-else>
                <strong>Map Bans</strong>
                <div class="map-banner" v-for="map in mapPool">
                  <p v-if="!mapIsBanned(map)">
                    <span :class="{selectedMap: banTurn == 0}">{{map}}</span>
                    <a href="#"
                       @click.prevent="banMap(map)"
                       v-show="banTurn != 0 && canBanMap">
                         {{ !loading ? 'Ban' : 'Banning...' }}
                    </a>
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
                <img :src="player.user.image" />
                {{player.user.name}} &dash; <span class="ladderpoints">{{player.user.ladder_points}}</span>
              </div>
            </div>
          </div>
        </section>
    </div>
  </div>
</template>

<script type="text/babel">
    var _ = require('lodash')
    export default {
        data() {
            return {
                loading: false,
                echoId: 0,
                mapPool: ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train']
            }
        },
        computed: {
            players() {
                return this.$store.state.players
            },
            gamePlayers() {
                return this.$store.state.game.players
            },
            game() {
                return this.$store.state.game
            },
            userid() {
              return this.$store.state.userid
            },
            inGame() {
              return this.game && this.game.id > 0
            },
            userPlayer() {
                return _.find(this.gamePlayers, {user: {id: this.userid}})
            },
            userReady() {
                return this.userPlayer.status_id > 0
            },
            allPlayersReady() {
                var ready = true
                _.forEach(this.gamePlayers, (player) => {
                    if(player.status_id == 0) ready = false
                })
                return ready
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
              if(this.banTurn === 0 || _.isEmpty(this.game)) return false
              return this.banTurn.user.id === this.userid
            }
        },
        methods: {
            startGameListener: function() {
              if(!this.game.id) {
                  console.log('no game id to listen to')
                  return false
              } else {
                  this.echoId = this.game.id
              }

              Echo.private('laddergame.' + this.game.id)
                  .listen('PlayerDrafted', (e) => {
                      this.playerDrafted(e.player)
                  })
                  .listen('MapBanned', (e) => {
                      this.mapBanned(e.map)
                  })
                  .listen('GameCancelled', (e) => {
                      var gameid = this.game.id
                      this.$store.commit('clearGame')
                      this.$router.push('/game/' + gameid)
                  })
                  .listen('GameAccepted', (e) => {
                      console.log(e)
                      this.$store.commit('updateGame', e.game)
                  })
                  .listen('GameDraftComplete', (e) => {
                      var gameid = this.game.id
                      // add a slight delay before transitioning
                      setTimeout(() => {
                          this.$router.push('/game/' + gameid)
                      }, 1500)
                  })
            },
            readyCheck() {
                this.loading = true
                var gameId = this.game.id
                this.$http.post('/readycheck', {gameId}).then((response) => {
                    this.loading = false
                    var players = this.game.players
                    var userplayer = _.find(players, {user: {id: this.userid}})
                    if(userplayer) {
                        userplayer.status_id = 10
                        this.$store.commit('userReady', players)
                    }
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
        watch: {
            'game': function(newgame) {
                console.log('game detected: ' + newgame.id)
                if(newgame.id && newgame.id !== this.echoId) {
                    console.log('starting game listener')
                    this.echoId = newgame.id
                    this.startGameListener()

                } else {
                    console.log('game listener already running')
                }
            }
        },
        mounted: function () {
          console.log('starting game listener from mount')
          this.startGameListener()
        }
    }
</script>
