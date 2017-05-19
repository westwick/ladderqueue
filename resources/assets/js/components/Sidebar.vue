<template>
    <div class="user-sidebar">

        <div class="sidebar-logo">
            <img src="/images/vx.png" />
        </div>

        <div class="queue-status">
            <playerqueue></playerqueue>
        </div>


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
                <div class="nav-bullet"><i class="icon ion-clipboard"></i></div>
                <a href="/">Game History</a>
            </li>
        </ul>

        <div class="sidebar-section-header">
            Account
        </div>

        <ul class="main-nav">
            <li>
                <div class="nav-bullet"><i class="icon ion-gear-a"></i></div>
                <a href="/">Settings</a>
            </li>
            <li>
                <div class="nav-bullet"><i class="icon ion-log-out"></i></div>
                <a href="/logout" @click.prevent="doLogout">
                    Logout
                </a>
            </li>
        </ul>

        <div class="placeholder-bar"></div>

        <div class="platform-status">
            <p>Queue: <span class="queue-online">Available</span></p>
            <p>Players online: <span class="queue-online">14</span></p>
            <p>Games in progress: <span class="queue-online">1</span></p>

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
