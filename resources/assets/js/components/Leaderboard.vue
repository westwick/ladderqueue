<template>
    <div v-if="loading" class="loading">
        <div class="loader-spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="small-12 columns">
            <p class="text-right" style="color: #676767; font-size: 14px; margin: 0 0 4px">Last updated: {{lastUpdated}}</p>
            <table class="leaderboard">
                <thead>
                <tr>
                    <th>Rank</th>
                    <th>Points</th>
                    <th>Player</th>
                    <th>Recent Performance</th>
                    <th>Streak</th>
                    <th>Record</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="player in leaderboard" :class="{'active-user': player.id === userid}">
                    <td>{{player.rank}}</td>
                    <td>{{player.ladder_points}}</td>
                    <td width="55%">{{player.name}}</td>
                    <td>
                        <div :id="'spark' + player.id"></div>
                    </td>
                    <td :class="getStreakClass(player.streak)">{{player.streak > 0 ? '+' + player.streak : player.streak}}</td>
                    <td :class="player.record !== '0 - 0' ? '':'nostreak'">{{player.record}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/babel">
    import moment from 'moment'
    export default {
        data() {
            return {
                loading: true,
                leaderboard: null,
                lastUpdated: ''
            }
        },
        computed: {
            userid() {
                return this.$store.state.userid
            },
            onlineUsers() {
                return this.$store.state.onlineUsers
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                var leaderboard = JSON.parse(window.localStorage.getItem('leaderboard'))
                if(leaderboard) {
                    setTimeout(() => {
                        this.loading = false
                        setTimeout(this.drawCharts, 1)
                    }, 100)
                    this.lastUpdated = moment(window.localStorage.getItem('leaderboardUpdated'), 'X').fromNow()
                    this.leaderboard = leaderboard
                } else {
                    this.refreshData()
                }
            },
            refreshData() {
                this.loading = true
                this.$http.post('/leaderboard').then((response) => {
                    this.loading = false
                    this.leaderboard = response.data
                    window.localStorage.setItem('leaderboardUpdated', moment().format('X'))
                    this.lastUpdated = moment().fromNow();
                    window.localStorage.setItem('leaderboard', JSON.stringify(response.data))
                    setTimeout(this.drawCharts, 1)

                }, (response) => {
                    this.loading = false
                })
            },
            isOnline(player) {
                var test = _.find(this.onlineUsers, {id: player.id})
                return JSON.toString(test)
            },
            getStreakClass(streak) {
                if(streak > 0) {
                    return 'streak-pos'
                } else if(streak < 0) {
                    return 'streak-neg'
                } else {
                    return 'nostreak'
                }
            },
            drawCharts() {
                _.forEach(this.leaderboard, (player) => {
                    if(player.sparkline.length > 2) {
                        var options = this.defaultOptions()
                        options.series = [{
                            data: player.sparkline,
                            pointStart: 1,
                            threshold: 0,
                            color: '#cddc39',
                            negativeColor: '#d41f26',
                        }]
                        var test = new Highcharts.chart('spark' + player.id, options)
                    }
                })
            },
            defaultOptions() {
                return {
                    chart: {
                        //renderTo: (options.chart && options.chart.renderTo) || this,
                        backgroundColor: null,
                        borderWidth: 0,
                        type: 'areaspline',
                        margin: [2, 0, 2, 0],
                        width: 120,
                        height: 20,
                        style: {
                            overflow: 'visible',
                            margin: '0 auto'
                        },

                        // small optimalization, saves 1-2 ms each sparkline
                        skipClone: true
                    },
                    title: {
                        text: ''
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        labels: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        startOnTick: false,
                        endOnTick: false,
                        tickPositions: []
                    },
                    yAxis: {
                        endOnTick: false,
                        startOnTick: false,
                        labels: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        tickPositions: [0],
                        gridLineWidth: 0,
                        minorGridLineWidth: 0
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        backgroundColor: '#121212',
                        borderWidth: '1',
                        borderColor: '#2e2e2e',
                        style: {
                            color: '#FFF'
                        },
                        shadow: false,
                        useHTML: true,
                        hideDelay: 0,
                        shared: true,
                        //padding: '3px',
                        formatter() {
                            console.log(this)
                            if(this.x > 1) {
                                var previousPoint = this.points[0].series.data[this.x-2].y
                                var currentPoint = this.y
                                var diff = currentPoint - previousPoint
                                return diff > 0 ? '+' + diff : diff
                            } else {
                                return this.y
                            }
                        },
                        positioner: function (w, h, point) {
                            return { x: point.plotX - w / 2, y: point.plotY - h };
                        }
                    },
                    plotOptions: {
                        series: {
                            animation: false,
                            lineWidth: 2,
                            shadow: false,
                            states: {
                                hover: {
                                    lineWidth: 2
                                }
                            },
                            marker: {
                                radius: 2,
                                states: {
                                    hover: {
                                        radius: 3
                                    }
                                }
                            },
                            fillOpacity: 0.38
                        },
                        column: {
                            negativeColor: '#910000',
                            borderColor: 'silver'
                        }
                    }
                }
            }
        }
    }
</script>
