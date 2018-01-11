<template>
    <div v-if="loading" class="loading">
        <div class="loader-spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="small-12 columns">
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
                    <td width="10%">
                        <template v-if="item.points > 0">
                            <span class="points-positive">
                                +{{item.points}}
                            </span>
                        </template>
                        <template v-else>
                            <span class="points-negative">
                                {{item.points}}
                            </span>
                        </template>
                    </td>
                    <td width="60%">{{item.memo}}</td>
                    <td width="30%">{{item.time_ago}}</td>
                </tr>
                </tbody>
            </table>
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
