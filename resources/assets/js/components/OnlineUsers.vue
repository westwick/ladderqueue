<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="panel">
                <p style="margin-bottom: 1rem">{{users.length}} users currently online</p>
                <div class="online-users">
                    <div class="online-user" v-for="user in users">
                        <img :src="user.image" class="user-image"/>
                        {{user.username}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        computed: {
            users() {
                return this.$store.state.onlineUsers
            }
        }
    }
</script>
