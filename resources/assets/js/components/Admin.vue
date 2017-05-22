<template>
    <div class="row">
        <div class="small-12 columns">
            <template v-if="isAdmin">
                <template v-if="users.length == 0">
                    <div class="panel admin-toolbar">
                        <button class="button" @click="clearQueue()">
                            {{ !clearing ? 'Clear Queue' : 'Clearing...' }}
                        </button>
                        <button class="button" @click="getUsers()">
                            {{ !loading ? 'Edit Users' : 'Loading...' }}
                        </button>
                    </div>
                </template>
            </template>
            <template v-else>
                <p class="text-center; font-size: 25px">Unauthorized</p>
            </template>

            <table v-if="users.length > 0 && !editUser">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Registered</th>
                        <th>Queue</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>{{user.name}}</td>
                        <td>{{user.created_at}}</td>
                        <td>
                            <template v-if="user.ladder_queue == 'vitalityx'">
                                VitalityX
                            </template>
                            <template v-else>
                                <span style="color: #666">not approved</span>
                            </template>
                        </td>
                        <td>
                            <button class="button" @click="setUser(user)">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <template v-if="editUser !== null">
                <a href="#" @click.prevent="clearEditUser"><i class="icon ion-ios-arrow-back"></i> Back</a>
                <div class="panel">
                    <p>Editing user <strong>{{editUser.name}}</strong></p>
                </div>
                <div class="panel">
                    <div class="row">
                        <div class="medium-6 columns">
                            <p><strong>Adjust points</strong></p>
                            <p style="margin-bottom: 1rem; color: #676767; font-size: 14px">Enter a positive number to add points or a negative number to subtract points. Make sure to include a memo, which the user will see.</p>
                            <input type="number" v-model="userPoints" placeholder="0" style="max-width: 100px" />
                            <input type="text" v-model="memo" placeholder="leave a memo about why" />
                            <button class="button" @click="adjustPoints()">Add/Remove Points</button>
                        </div>
                        <div class="medium-6 columns">
                            <p><strong>Queue Status</strong></p>
                            <p v-if="editUser.ladder_queue !== 'vitalityx'">
                                <button class="button" @click="addQueuePrivileges">
                                    {{ !posting ? 'Grant Privileges' : 'Updating' }}
                                </button>
                            </p>
                            <p v-else>
                                <button class="button" @click="removeQueuePrivileges">
                                    {{ !posting ? 'Remove Privileges' : 'Updating' }}
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
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
            getUsers() {
                this.loading = true
                this.$http.post('/admin/users').then((response) => {
                    this.users = response.data
                    this.loading = false
                }, (response) => {
                    this.loading = false
                })
            },
            setUser(user) {
                this.editUser = user
            },
            clearEditUser() {
                this.editUser = null
            },
            clearQueue() {
                this.clearing = true
                this.$http.post('/admin/clearqueue').then((response) => {
                    this.clearing = false
                }, (response) => {
                    this.clearing = false
                })
            },
            addQueuePrivileges() {
                this.posting = true
                this.$http.post('/admin/approve', {userid: this.editUser.id}).then((r) => {
                    this.posting = false
                    this.editUser.ladder_queue = 'vitalityx'
                    toastr.success(this.editUser.name + ' can now queue')
                })
            },
            removeQueuePrivileges() {
                this.posting = true
                this.$http.post('/admin/remove', {userid: this.editUser.id}).then((r) => {
                    this.posting = false
                    this.editUser.ladder_queue = ''
                    toastr.success(this.editUser.name + ' can no longer queue')
                })
            },
            adjustPoints() {
                if(this.memo.length < 1) {
                    toastr.error('you must include a memo about the point change')
                    return false
                }
                if(this.userPoints === 0) {
                    toastr.error('points must be greater than or less than zero')
                    return false
                }
                this.$http.post('/admin/adjust-points', {userid: this.editUser.id, points: this.userPoints, memo: this.memo}).then((r) => {
                    this.userPoints = 0
                    this.memo = ''
                    toastr.success('Great Success!')
                })
            }
        }
    }
</script>
