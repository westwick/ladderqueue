<template>
    <div class="user-sidebar">

        <div class="sidebar-logo">
            <img src="/images/vx.png" />
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
                <a href="/">
                    <div class="nav-bullet"><i class="icon ion-clipboard"></i></div>
                    Game History
                </a>
            </li>
        </ul>

        <div class="sidebar-section-header">
            Account
        </div>

        <ul class="main-nav">
            <li>
                <a href="/">
                    <div class="nav-bullet"><i class="icon ion-gear-a"></i></div>
                    Settings
                </a>
            </li>
            <li>
                <a href="/logout" @click.prevent="doLogout">
                    <div class="nav-bullet"><i class="icon ion-log-out"></i></div>
                    Logout
                </a>
            </li>
        </ul>

        <div class="placeholder-bar"></div>

        <div class="platform-status">
            <p>Queue: <span class="queue-online">Available</span></p>
            <p>Players online: <router-link to="/">15</router-link></p>
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
            console.log('Component mounted.')
        },
        methods: {
            doLogout: function() {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
