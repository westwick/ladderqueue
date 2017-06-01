<template>
    <div class="row">
        <div class="medium-6 columns">
            <template>
                <div class="panel nmt news-item">
                    <div class="news-inner">
                        <h5 class="title">v0.1.1</h5>
                        <p class="author-info">Posted by <span>@drew</span> on May 31, 2017</p>
                        <div>
                            <p>Fixed a bug that was preventing the queue from popping.</p>
                        </div>
                    </div>
                </div>
                <div class="panel nmt news-item">
                    <div class="news-inner">
                        <h5 class="title">v0.1.0 - New Season</h5>
                        <p class="author-info">Posted by <span>@drew</span> on May 31, 2017</p>
                        <div>
                            <p>Just a small release this time to add last season's stats to player profiles, as well as some minor changes to prepare the database for the new season.</p>
                        </div>
                    </div>
                </div>
                <div class="panel nmt news-item">
                    <div class="news-inner">
                        <h5 class="title">v0.0.5</h5>
                        <p class="author-info">Posted by <span>@drew</span> on May 31, 2017</p>
                        <div>
                            <ul>
                                <li>Added desktop notifications - you must enable them in your settings</li>
                                <li>Settings page now works</li>
                                <li>Fixed the bug that prevented the queue sound from playing when the browser window was not active</li>
                                <li>Added player information to settings and profile pages</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="medium-6 columns">
            <div class="panel nmt news-item support-info">
                <div class="news-inner">
                    <h5 class="title">Credits</h5>
                    <h6>Owner</h6>
                    <p><a href="#">@jam</a></p>
                    <h6>Development</h6>
                    <p><a href="#">@drew</a></p>
                    <h6>Design</h6>
                    <p><a href="#">@rep</a></p>
                    <h6>Admins</h6>
                    <p>
                        <a href="#">@Frostay</a>,
                        <a href="#">@Tribut3</a>,
                        <a href="#">@kel</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        computed: {
            newsItems() {
                return this.$store.state.news
            }
        }
    }
</script>
