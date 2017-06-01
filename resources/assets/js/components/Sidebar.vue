<template>
    <div class="user-sidebar">

        <div class="sidebar-logo">
            <router-link to="/"><img src="/images/vxblue.png" /></router-link>
        </div>


        <playerqueue></playerqueue>


        <div class="sidebar-section-header">
            Navigation
        </div>

        <ul class="main-nav">
            <li>
                <router-link to="/" exact>
                    <div class="nav-bullet"><i class="icon ion-radio-waves"></i></div>
                    News
                </router-link>
            </li>
            <li>

                <router-link to="/leaderboard">
                    <div class="nav-bullet"><i class="icon ion-trophy"></i></div>
                    Leaderboard
                </router-link>
            </li>
            <li>
                <router-link to="/games">
                    <div class="nav-bullet"><i class="icon ion-clipboard"></i></div>
                    Game History
                </router-link>
            </li>
            <li v-if="isAdmin">
                <router-link to="/admin">
                    <div class="nav-bullet"><i class="icon ion-flash"></i></div>
                    Admin
                </router-link>
            </li>
        </ul>

        <div class="sidebar-section-header">
            Account
        </div>

        <ul class="main-nav">
            <li>
                <router-link :to="'/u/' + username">
                    <div class="nav-bullet"><i class="icon ion-stats-bars"></i></div>
                    My Profile
                </router-link>
            </li>
            <li>
                <router-link to="/settings">
                    <div class="nav-bullet"><i class="icon ion-gear-a"></i></div>
                    Settings
                </router-link>
            </li>
            <li>
                <a href="/logout" @click.prevent="doLogout">
                    <div class="nav-bullet"><i class="icon ion-log-out"></i></div>
                    Log Out
                </a>
            </li>
        </ul>

        <div class="placeholder-bar"></div>

        <div class="platform-status">
            <p>Queue: <span class="queue-online">Available</span></p>
            <p>Players online: <router-link to="/players">{{onlineUserCount}}</router-link></p>
            <p>Games in progress: <router-link to="/games/live">{{gamesInProgressCount}}</router-link></p>

            <div class="version">
                <router-link to="/about">Beta v0.1.0</router-link>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        mounted() {

            window.localStorage.removeItem('leaderboard')

            Echo.join('players')
                .here((users) => {
                    this.$store.commit('onlineUsers', users)
                })
                .joining((user) => {
                    var users = this.$store.state.onlineUsers
                    users.push(user)
                    this.$store.commit('onlineUsers', users)
                })
                .leaving((user) => {
                    var users = this.$store.state.onlineUsers
                    var newUsers = _.filter(users, function(newUser) {
                        return newUser.id !== user.id
                    })
                    this.$store.commit('onlineUsers', newUsers)
                });
        },
        computed: {
            onlineUserCount() {
                return this.$store.state.onlineUsers.length
            },
            gamesInProgressCount() {
                return this.$store.state.games.length
            },
            isAdmin() {
                return this.$store.state.is_admin
            },
            username() {
                return this.$store.state.username.toLowerCase()
            }
        },
        methods: {
            doLogout: function() {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
