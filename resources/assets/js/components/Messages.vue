<template>
    <div class="messages-container">
        <div class="show-older" v-show="olderButtonVisible">
            <button class="button button-outline" @click="showMore">Show Older</button>
        </div>
        <div id="convo" class="messages" :style="getHeight()">
            <div v-for="message in messages" class="chat-wrap">
                <img class="speaker-avatar" :src="message.from.image" />
                <div class="message" :class="message.from.id !== userid ? 'message-white':''">
                    <p class="message-body">{{message.content}}</p>
                    <p class="timestamp">Sent {{message.sentDate}}<span class="cooldividier"></span>{{message.sentTime}}</p>
                </div>
            </div>

            <div class="chat-wrap send-message-form">
                <img class="speaker-avatar" :src="user.image" />
                <div class="message message-input">
                <textarea placeholder="Type your message here"
                          class="newmessage"
                          maxlength="240"
                          v-model="newmsg"
                          :disabled="loading"
                >
                </textarea>
                    <template v-if="this.loading">
                        <button class="button disabled sendbutton">Sending</button>
                    </template>
                    <template v-else>
                        <button class="button sendbutton" @click.prevent="sendMsg">Send</button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['msgs', 'recipient', 'user', 'convoid'],
        data() {
            return {
                messages: this.msgs,
                loading: false,
                newmsg: '',
                showOlder: 2,
                olderButtonVisible: false
            }
        },
        computed: {
            userid() {
                return this.$store.state.userid
            }
        },
        methods: {
            sendMsg() {
                this.loading = true
                this.$http.post('/send-msg', {'to_user_id': this.recipient.id, 'message': this.newmsg}).then((resp) => {
                    this.loading = false
                    this.newmsg = ''
                    var newmsgs = this.messages
                    newmsgs.push(resp.data.message)
                    this.messages = newmsgs
                    setTimeout(this.setHeight, 60)
                })
            },
            getHeight() {
                return {
                    'max-height': 40*this.showOlder + 'vh'
                }
            },
            showMore() {
                this.showOlder = this.showOlder + 1
                this.setHeight()
            },
            setHeight() {
                document.getElementById('convo').scrollTop = 100000
                this.checkButtonVisibility()
            },
            checkButtonVisibility() {
                var st = document.getElementById('convo').scrollTop
                this.olderButtonVisible = (st > 0)
            },
            startChatListener() {
                Echo.private('convo.' + this.convoid)
                    .listen('ConversationMessage', (e) => {
                        console.log(e)
                        var messages = this.messages
                        var newmessage = e.message
                        newmessage.from = e.from
                        messages.push(newmessage)
                        this.messages = messages
                        setTimeout(this.setHeight, 60)
                        //this.setHeight()
                    })
            }
        },
        mounted() {
            this.setHeight()
            this.startChatListener()
        }
    }
</script>
