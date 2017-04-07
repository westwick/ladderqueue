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
                console.log('caught an emit')
                this.unread = count
                document.title = '[' + count + '] - Continental eSports'
            }
        }
    }
</script>
