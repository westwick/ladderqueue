<template>
    <div id="test">
        <sidebar></sidebar>
        <div class="content-area">
            <div class="content-head text-right">
                Logged in as <strong>drew</strong> &mdash; Current Rank: <strong>29</strong>
            </div>
            <div class="router-wrap">
                <router-view></router-view>
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
                loading: false,
                mapPool: ['inferno', 'cache', 'nuke', 'cobblestone', 'mirage', 'overpass', 'train']
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
