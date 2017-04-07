<template>
    <div class="conversations">
        <div class="convo-wrap" v-for="convo in sortedConvos">
            <a :href="'/messages/' + otherUser(convo).user.name.toLowerCase()">
                <div class="panel player-message-brief" :class="isActive(convo) ? 'active-convo':''">
                    <template v-if="participant(convo) && participant(convo).unreadCount > 0">
                        <div class="message-read-status unread-messages">{{participant(convo).unreadCount}}</div>
                    </template>
                    <template v-else-if="repliedAndReceived(convo)">
                        <div class="message-read-status read-or-replied">
                            <i class="icon ion-checkmark"></i>
                        </div>
                    </template>
                    <template v-else-if="notReplied(convo)">
                        <div class="message-read-status read-or-replied">
                            <i class="icon">&nbsp;</i>
                        </div>
                    </template>
                    <template v-else-if="replied(convo)">
                        <div class="message-read-status read-or-replied">
                            <i class="icon ion-reply"></i>
                        </div>
                    </template>
                    <img class="player-avatar" :src="otherUser(convo).user.image" />
                    <div class="player-message">
                        <strong>{{otherUser(convo).user.name}}</strong>
                        <p class="previewline" v-if="otherUser(convo).lastMessage">
                            {{otherUser(convo).lastMessage.content}}
                        </p>
                    </div>
                    <div class="message-timestamp">
                        <p>{{convo.lastUpdatedDiff}}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="view-all" v-show="hiddenConvos > 0">
            <a href="/messages" class="">View All</a>
        </div>
    </div>
</template>

<script type="text/babel">
    var _ = require('lodash')

    export default {
        props: ['convos', 'maxItems'],
        data() {
            return {
                conversations: this.convos,
                maxConvos: this.maxItems || 0
            }
        },
        computed: {
            userid() {
                return this.$store.state.userid
            },
            sortedConvos() {
                var unsorted = this.conversations
                var convos = []
                if(this.maxConvos > 0 && unsorted.length > this.maxConvos) {
                    convos = unsorted.slice(0,3)
                    var regex = /^\/messages\/[a-zA-Z0-9]+$/g
                    if(regex.test(document.location.pathname)) {
                        // if we are on an active conversation
                        // make sure it is in the sorted list
                        var hasActive = false
                        _.forEach(convos, (c) => {
                            if(this.isActive(c)) {
                                hasActive = true
                            }
                        })
                        if(!hasActive) {

                            var activeConvo = this.findActiveConvo(unsorted)
                            if(activeConvo) {
                                convos = convos.slice(0,2)
                                convos.push(activeConvo)
                            }

                        }
                    }
                } else {
                    convos = unsorted
                }
                return convos
            },
            hiddenConvos() {
                return this.conversations.length - this.sortedConvos.length
            },
            totalUnread() {
                var unread = 0
                _.forEach(this.conversations, (o) => {
                    var p = this.participant(o)
                    if(p) {
                        unread += p.unreadCount
                    }
                })
                return unread
            }
        },
        methods: {
            participant: function(convo) {
                return _.find(convo.participants, (o) => { return o.user_id === this.userid })
            },
            otherUser: function(convo) {
                return _.find(convo.participants, (o) => { return o.user_id !== this.userid })
            },
            isActive: function(convo) {
                var regex = /^\/messages\/[a-zA-Z0-9]+$/g
                if(regex.test(document.location.pathname)) {
                    var convoWith = document.location.pathname.substring(10)
                    return this.otherUser(convo).user.name.toLowerCase() === convoWith.toLowerCase()
                } else {
                    return false
                }
            },
            findActiveConvo: function() {
                var regex = /^\/messages\/[a-zA-Z0-9]+$/g
                var active = null
                if(regex.test(document.location.pathname)) {
                    var convoWith = document.location.pathname.substring(10)
                    _.forEach(this.conversations, (c) => {
                        if(this.otherUser(c).user.name.toLowerCase() === convoWith.toLowerCase()) {
                            active = c
                        }
                    })
                } else {
                    return false
                }
                return active
            },
            notReplied: function(convo) {
                var user = this.participant(convo)
                var recipient = this.otherUser(convo)
                if (!user || !user.lastMessage) {
                    return true
                } else {
                    return recipient.lastMessage && user.lastMessage.created_at < recipient.lastMessage.created_at
                }
            },
            replied: function(convo) {
                var user = this.participant(convo)
                var recipient = this.otherUser(convo)
                if (!user.lastMessage) return false
                if (!recipient.lastMessage) return true
                return user.lastMessage.created_at > recipient.lastMessage.created_at
            },
            repliedAndReceived: function(convo) {
                var user = this.participant(convo)
                var recipient = this.otherUser(convo)
                return user && this.replied(convo) && user.lastMessage.created_at < recipient.last_read
            },
            startConvoListener: function() {
                Echo.private('App.User.' + this.$store.state.userid)
                        .listen('ConversationsUpdated', (e) => {
                            // if this conversation is open in Messages.vue component
                            // we will ignore this event and just send a 'read' response back to server
                            // to update the last_read timestamp
                            console.log(e)
                            var regex = /^\/messages\/[a-zA-Z0-9]+$/g
                            if(regex.test(document.location.pathname)) {
                                var convoWith = document.location.pathname.substring(10)
                                if(e.sender.name.toLowerCase() === convoWith.toLowerCase()) {
                                    this.$http.post('/read-convo', {id: e.conversation.id})
                                }
                            } else {
                                // otherwise, we will make a call to the server to get the updated messages status
                                this.$http.post('/get-messages').then((resp) => {
                                    this.conversations = resp.data.messages
                                    // this lets the ConversationNav component know so it can update
                                    this.$emit('newunread', this.totalUnread)
                                })
                            }
                        })
            }
        },
        mounted() {
            this.startConvoListener()
        }
    }
</script>
