<template>
    <div class="hidden">No</div>
</template>

<script type="text/babel">
    export default {
        props: ['userstate', 'csrftoken'],
        data() {
            return {

            }
        },
        methods: {
            setUserstate: function() {
                this.$store.commit('setUserstate', this.userstate)
                this.$store.commit('setCsrfToken', this.csrftoken)
            },
            startPartyListener: function() {
                Echo.private('App.User.' + this.$store.state.userid)
                    .notification((notification) => {

                    })
            },
            processNotification: function(notification) {
                if(notification.type === "App\\Notifications\\TeammateBracketRegistrationStarted") {
                    this.$store.commit('addParty', notification.data)
                }
            }
        },
        created: function () {
            this.setUserstate();

            // only start listeners if logged in
            if(this.$store.state.loggedIn) {
                Echo.private('App.User.' + this.$store.state.userid)
                    .notification((notification) => {
                        console.log(notification.type, notification);
                        this.processNotification(notification)
                    })

                Echo.private('users.' + this.$store.state.userid)
                    .listen('BracketRegistrationStarted', (e) => {
                        console.log(e);
                    })
            }
        }
    }
</script>
