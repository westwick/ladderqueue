<template>
    <div>
        <div v-if="party && partyCreatorName" class="extra-padder"></div>
        <div v-show="party && partyCreatorName" class="party-notifier">
            <div v-if="partyPlayerStatus > 0">
                <p>Your team is assembling - <a :href="'/assemble/' + party.id">View</a></p>
            </div>
            <div v-else>
                <p>
                    {{ partyCreatorName }} wants to join an event.
                    <a href="#" class="button" @click.prevent="joinParty()">Join</a>
                    or
                    <a href="#" @click.prevent="declineParty()">decline</a>
                    <form method="post" action="/join-party" id="joinparty">
                        <input type="hidden" name="_token" :value="csrfToken" />
                        <input type="hidden" name="partyId" :value="party.id" />
                    </form>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    var _ = require('lodash')
    export default {
        computed: {
            csrfToken() {
                return this.$store.state.csrfToken
            },
            userid() {
                return this.$store.state.userid
            },
            party() {
                return this.$store.state.party
            },
            partyCreatorName() {
                if(this.$store.state.party.creator) {
                    return this.$store.state.party.creator.name
                } else {
                    return false
                }
            },
            user() {
              return _.find(this.$store.state.party.players, {id: this.userid})
            },
            partyPlayerStatus() {
              if(!this.party || !this.user.pivot) return 0
              return this.user.pivot.status_id
            }
        },
        methods: {
            joinParty() {
              document.getElementById('joinparty').submit()
            },
            declineParty() {
                this.$http.post('/decline-party', {partyid: this.party.id})
                this.$store.commit('clearParty')
                toastr.success('You declined the invitation')
            }
        }
    }
</script>
