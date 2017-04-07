<template>
    <div class="convonav">
        <a href="#" class="message-toggle nav-toggle">
            <i class="icon ion-email"></i>
            <div class="unread-count" v-if="unread > 0">
                <span>{{unread}}</span>
            </div>
        </a>
        <div class="subnav message-subnav">
            <conversations :convos="conversations" :max-items="3" v-on:newunread="updateUnread"></conversations>
            <a href="/messages" class="view-all-messages">View All</a>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['convos', 'unreadcount'],
        data() {
            return {
                conversations: this.convos,
                unread: this.unreadcount || 0
            }
        },
        methods: {
            updateUnread: function(count) {
                this.unread = count
                if(count > 0) {
                    document.title = '[' + count + '] - Continental eSports'
                } else {
                    document.title = 'Continental eSports'
                }
            }
        }
    }
</script>
