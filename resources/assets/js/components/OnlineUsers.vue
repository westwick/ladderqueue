<template>
    <div class="row">
        <div class="small-12 columns">
            <div class="panel">
                <p v-for="user in users">{{user.username}}</p>
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
