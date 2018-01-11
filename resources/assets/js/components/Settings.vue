<template>
    <div class="settings-page">
        <div class="row">
            <div class="small-12 columns text-right">
                <button class="button" @click="saveSettings()" :disabled="saving">
                    {{ !saving ? 'Save Settings' : 'Saving...' }}
                </button>
            </div>
        </div>
        <div class="row">
            <div class="medium-6 columns">
                <div class="panel nmt">
                    <h4>Profile Settings</h4>
                    <p>Location</p>
                    <input type="text" placeholder="New York, NY" v-model="profile.location" />

                    <p>Age</p>
                    <input type="number" placeholder="18" v-model.number="profile.age" />

                    <p>Short Bio</p>
                    <textarea v-model="profile.intro" placeholder="A brief description about yourself"></textarea>

                    <p>Twitch Stream</p>
                    <input type="text" v-model="profile.twitch" placeholder="twitch.tv/example"/>

                    <p>Twitter Handle</p>
                    <input type="text" v-model="profile.twitter" placeholder="@example" />
                </div>
            </div>
            <div class="medium-6 columns">
                <div class="panel nmt">
                    <h4>Account Settings</h4>

                    <p>Play sound when queue pops</p>
                    <div class="switch tiny">
                        <input class="switch-input" id="playsounds" type="checkbox" name="playsounds" v-model="userSettings.sound_enabled">
                        <label class="switch-paddle" for="playsounds">
                            <span class="show-for-sr">Desktop Notifications</span>
                            <span class="switch-active" aria-hidden="true">On</span>
                            <span class="switch-inactive" aria-hidden="true">Off</span>
                        </label>
                    </div>

                    <p>Desktop Notifications</p>
                    <div class="switch tiny">
                        <input class="switch-input" id="shownotification" type="checkbox" name="shownotifications" v-model="userSettings.notifications_enabled">
                        <label class="switch-paddle" for="shownotification">
                            <span class="show-for-sr">Desktop Notifications</span>
                            <span class="switch-active" aria-hidden="true">On</span>
                            <span class="switch-inactive" aria-hidden="true">Off</span>
                        </label>
                    </div>

                    <p>Timezone</p>
                    <select v-model="userSettings.timezone">
                        <option>Eastern</option>
                        <option>Central</option>
                        <option>Mountain</option>
                        <option>Pacific</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import Push from 'push.js'
    export default {
        data() {
            return {
                saving: false,
                userSettings: {
                    sound_enabled: true,
                    notifications_enabled: false,
                    timezone: ''
                },
                profile: {
                    location: '',
                    age: '',
                    intro: '',
                    twitch: '',
                    twitter: ''
                }
            }
        },
        mounted() {
            this.userSettings = this.storeSettings
            this.profile = this.storeProfile
        },
        computed: {
            storeSettings() {
                return this.$store.state.settings
            },
            storeProfile() {
                return this.$store.state.profile
            }
        },
        watch: {
            'userSettings.notifications_enabled': 'notificationToggle'
        },
        methods: {
            saveSettings() {
                var settings = this.userSettings
                var profile = this.profile
                this.saving = true
                this.$http.post('/api/update-settings', {settings, profile}).then((response) => {
                    toastr.success('Settings successfully saved')
                    this.profile = response.data
                    profile = response.data
                    this.$store.commit('saveSettings', {settings, profile})
                    this.saving = false
                }, (response) => {
                    toastr.error('Something went wrong')
                    this.saving = false
                })
            },
            askForPriv() {
                Push.Permission.request(() => {
                    // do nothing, all good :)
                }, () => {
                    this.userSettings.notifications_enabled = false
                    toastr.error('You must accept in order to receive desktop notifications')
                });
            },
            notificationToggle() {
                if(this.userSettings.notifications_enabled) {
                    this.askForPriv()
                }
            }
        }
    }
</script>
