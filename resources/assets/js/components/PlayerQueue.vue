<template>
  <div>
      <div v-if="players.length >= 10">
        <p>Starting a game, please wait...</p>
      </div>
      <div v-else>
        <div v-if="!inQueue">
          <button class="button queue-button" @click.disable="enterQueue" :disabled="this.loading">
              {{ !this.loading ? 'Join Queue': 'Joining...'}}
          </button>
        </div>
        <div v-if="inQueue">
          <p class="queue-timer">Queued &mdash; {{inQueueFor}}</p>
          <a href="#" @click.disable="leaveQueue" :disabled="this.loading">
              {{ !this.loading ? 'Leave Queue': 'Leaving...'}}
          </a>
        </div>
        <p class="queue-count">Players in queue: <span>{{players.length}}/10</span></p>
      </div>
  </div>
</template>

<script type="text/babel">
    var _ = require('lodash')
    var Timer = require('easytimer')
    export default {
        data() {
            return {
                inQueueFor: '00:00:00',
                loading: false,
                mapPool: ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train']
            }
        },
        computed: {
            players() {
                return this.$store.state.players
            },
            game() {
                return this.$store.state.game
            },
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
                    .listen('GameStarting', (e) => {
                        var userIsInGame = false
                        _.forEach(e.game.players, (player) => {
                          if(player.user.id === this.userid) {
                            userIsInGame = true
                          }
                        })
                        if(userIsInGame) {
                          console.log('starting game', e.game)
                          this.game = e.game
                          this.startGameListener()
                        } else {
                          location.reload()
                        }
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

                    var timer = new Timer()
                    timer.start()
                    timer.addEventListener('secondsUpdated', (e) => {
                        this.inQueueFor = timer.getTimeValues().toString()
                    })
                }).catch((error) => {
                    this.loading = false
                    if(error.response) {
                      var retryafter = error.response.headers["retry-after"]
                      toastr.error("You're doing that too fast. Try again in " + retryafter + " seconds")
                    }
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
            }
        },
        created: function () {
            this.startPartyListener()
        }
    }
</script>
