<template>
    <div id="test">
        <sidebar></sidebar>
        <div class="content-area">
            <div class="content-head text-right">
                Logged in as <strong>{{username}}</strong>
            </div>
            <div class="router-wrap">
                <transition name="slide-fade" appear mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['initplayers', 'initgame'],
        data() {
            return {
                players: this.initplayers,
                game: this.initgame,
                loading: false
            }
        },
        computed: {
            username() {
                return this.$store.state.username
            }
        },
        mounted() {
            var data = {};
            data.players = this.players
            data.game = this.game
            this.$store.commit('setGamestate', data)
        }
    }
</script>
