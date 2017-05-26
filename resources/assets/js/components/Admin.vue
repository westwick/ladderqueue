<template>
    <div class="row">
        <div class="small-12 columns">
            <template v-if="isAdmin">
                <template v-if="users.length == 0">
                    <div class="panel admin-toolbar">
                        <button class="button" @click="clearQueue()">
                            <i class="icon ion-android-refresh"></i>
                            {{ !clearing ? 'Clear Queue' : 'Clearing...' }}
                        </button>
                        <router-link to="/admin/users" class="button">
                            <i class="icon ion-ios-people"></i>
                            Edit Users
                        </router-link>
                        <router-link to="/admin/news" class="button">
                            <i class="icon ion-compose"></i>
                            Edit News
                        </router-link>
                    </div>
                </template>
            </template>
            <template v-else>
                <p class="text-center; font-size: 25px">Unauthorized</p>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: false,
                clearing: false,
                users: [],
                editUser: null,
                posting: false,
                userPoints: 0,
                memo: ''
            }
        },
        computed: {
            isAdmin() {
                return this.$store.state.is_admin
            }
        },
        methods: {
            clearQueue() {
                this.clearing = true
                this.$http.post('/admin/clearqueue').then((response) => {
                    this.clearing = false
                }, (response) => {
                    this.clearing = false
                })
            }
        }
    }
</script>
