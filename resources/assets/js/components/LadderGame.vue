<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="panel nmt text-center">
                <div class="loading" v-if="loading">
                    Loading...
                </div>
                <div v-else>
                    <div v-if="game">
                        <div v-if="game.status_id == 20">
                            <p>Waiting for someone to create the game</p>
                        </div>
                        <div v-if="game.status_id == 91">
                            <p>Game cancelled - not all players accepted the ready check</p>
                        </div>
                    </div>
                    <div v-else>
                        <p>Error: Game id {{$route.params.id}} could not be found</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: true,
                game: null
            }
        },
        created() {
            this.fetchData()
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData() {
                this.loading = true
                this.$http.post('/gameinfo', {id: this.$route.params.id}).then((response) => {
                    this.loading = false
                    this.game = response.data
                }, (response) => {
                    this.loading = false
                })
            }
        }
    }
</script>
