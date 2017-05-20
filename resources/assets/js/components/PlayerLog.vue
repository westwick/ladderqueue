<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="loading" v-if="loading">
                <div class="panel nmt text-center">
                    Loading...
                </div>
            </div>
            <div v-else>
                <table class="leaderboard">
                    <thead>
                    <tr>
                        <th>Points</th>
                        <th>Memo</th>
                        <th>When</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in log">
                        <td width="10%">{{item.points}}</td>
                        <td width="60%">{{item.memo}}</td>
                        <td width="30%">{{item.time_ago}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: true,
                log: null
            }
        },
        computed: {
            userid() {
                return this.$store.state.userid
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.loading = true
                this.$http.post('/playerlog').then((response) => {
                    this.loading = false
                    this.log = response.data
                }, (response) => {
                    this.loading = false
                })
            }
        }
    }
</script>
