<template>
    <div class="user-sidebar">

        <div class="sidebar-logo">
            <img src="/images/vxblue.png" />
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
        </ul>

        <div class="sidebar-section-header">
            Account
        </div>

        <ul class="main-nav">
            <li>
                <router-link to="/log">
                    <div class="nav-bullet"><i class="icon ion-stats-bars"></i></div>
                    Player Log
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
            <p>Players online: <router-link to="/">{{onlineUserCount}}</router-link></p>
            <p>Games in progress: <router-link to="/">2</router-link></p>

            <div class="version">
                Beta v0.0.1
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        mounted() {
            Echo.join('players')
                .here((users) => {
                    this.$store.commit('onlineUsers', users)
                })
                .joining((user) => {
                    console.log(user.username + ' joined');
                })
                .leaving((user) => {
                    console.log(user.username + 'left');
                });
        },
        computed: {
            onlineUserCount() {
                return this.$store.state.onlineUsers.length
            }
        },
        methods: {
            doLogout: function() {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
