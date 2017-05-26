<template>
    <div class="row">
        <div class="medium-6 columns">
            <template v-for="news in newsItems">
                <div class="panel nmt news-item">
                    <div class="news-inner">
                        <h5 class="title">{{news.title}}</h5>
                        <p class="author-info">Posted by <span>@{{news.user.name}}</span> on {{news.posted_on}}</p>
                        <div v-html="news.body"></div>
                    </div>
                </div>
            </template>
        </div>
        <div class="medium-6 columns">
            <div class="panel nmt news-item support-info">
                <div class="news-inner">
                    <h5 class="title">Support</h5>
                    <h6>Join our Teamspeak server</h6>
                    <p>Our teamspeak is where most of our players hang out. Feel free to join and talk throughout your ladder adventures: <a href="#">vitalityx.ts.nfoservers.com</a></p>
                    <h6>Report a bug or issue</h6>
                    <p>Please let us know if you find a bug on the site through one of contact methods below. If you find a bug you'll be rewarded with a badge on your player profile!</p>
                    <h6>Have another idea?</h6>
                    <p>We'd love to hear your thoughts on how to improve the experience. If you have an idea, hop in our discord and post it in the ideas channel!</p>
                    <h6>Contact</h6>
                    <p>
                    <ul>
                        <li>Teamspeak: <a href="#">vitalityx.ts.nfoservers.com</a></li>
                        <li>Discord: <a href="https://discord.gg/XHNAKZs" target="_blank">discord.gg/XHNAKZs</a></li>
                        <li>Twitter: <a href="https://twitter.com/vitality_x" target="_blank">@vitality_x</a></li>
                        <li>Email: <a href="#">vitalityxleague@gmail.com</a></li>
                    </ul>
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
