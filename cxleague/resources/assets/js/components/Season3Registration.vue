<template>
    <div class="regform">
        <section class="form-section acknowledgements">
            <div class="form-section-title">Acknowledgements</div>
            <div class="ac-custom ac-checkbox ac-checkmark">
                <div class="input-wrap">
                    <input id="cb1" name="cb1" type="checkbox" v-model="cb1">
                    <label for="cb1">I have fully read and understand the Season 3 Rules</label>
                </div>
                <div class="input-wrap">
                    <input id="cb2" name="cb2" type="checkbox" v-model="cb2">
                    <label for="cb2">My teammates and I agree to abide by the Player Code of Conduct</label>
                </div>
                <div class="input-wrap">
                    <input id="cb3" name="cb3" type="checkbox" v-model="cb3">
                    <label for="cb3">I understand there is a $5 fee to add new players after the deadline</label>
                </div>
                <div class="input-wrap">
                    <input id="cb4" name="cb4" type="checkbox" v-model="cb4">
                    <label for="cb4">I understand my team must maintain a core roster of 3 players</label>
                </div>
                <div class="input-wrap">
                    <input id="cb5" name="cb5" type="checkbox" v-model="cb5">
                    <label for="cb5">I understand there are no refunds</label>
                </div>
            </div>
        </section>
        <section class="form-section server-preference">
            <div class="form-section-title">Server Preference</div>
            <select name="serverpreference" v-model="serverpref">
                <option value="none">Select your server preference</option>
                <option value="east">East coast (New York)</option>
                <option value="west">West coast (San Francisco)</option>
            </select>
        </section>
        <section class="form-section team-time-zone">
            <div class="form-section-title">Team Timezone</div>
            <select name="teamtimezone" v-model="selectedTz">
                <option v-for="tz in timezoneOptions" :value="tz.value">{{tz.text}}</option>
            </select>
        </section>
        <section class="form-section game-availability">
            <div class="form-section-title">Game Availability</div>
            <div class="form-section-note">
              CarbonX will schedule your games according to the availability below.
              <br />All times displayed in your selected timezone ({{ selectedTzDisplay() }}). Select at least 5 different times.
            </div>
            <div v-for="day in scheduleOptions" class="schedule-day">
              <input type="checkbox" v-model="day.selected"/> {{ day.label }}
                <div v-if="day.selected" class="schedule-times">
                  <span v-for="t in day.times" class="time-select">
                    <input type="checkbox" :name="getCheckboxName(day.label, t.label)" v-model="t.selected"/> {{ timeDisplay(t.label) }}
                  </span>
                </div>
            </div>
        </section>
        <section>
            <div class="form-section-title" style="margin-bottom: 0.5rem">Complete Application</div>
            <div class="form-errors" v-if="!canSubmit">
              <p v-show="!termsAgreed" class="form-error">You must agree to all terms</p>
              <p v-show="serverpref === 'none'" class="form-error">Please select a server preference</p>
              <p v-show="selectedTimes.length < 5" class="form-error">You must select at least 5 times your team is available to play</p>
            </div>
            <button class="button" @click.prevent="submitForm()" :disabled="!canSubmit">Submit Registration</button>
            <p class="smalltext">You may pay the $30 registration fee separately from this application.</p>
        </section>
    </div>
</template>

<script>
    var _ = require('lodash')
    export default {
        computed: {
          selectedTimes() {
            var selected = []
            var days = _.forEach(this.scheduleOptions, function(day) {
              var times = _.forEach(day.times, function(time) {
                if(time.selected) {
                  selected.push(day + "." + time)
                }
              })
            })
            return selected
          },
          termsAgreed() {
            return this.cb1 && this.cb2 && this.cb3 && this.cb4 && this.cb5
          },
          canSubmit() {
             return this.termsAgreed && this.serverpref !== 'none' && this.selectedTimes.length >= 5
          }
        },
        data() {
            return {
                cb1: false,
                cb2: false,
                cb3: false,
                cb4: false,
                cb5: false,
                serverpref: 'none',
                selectedTz: 'America/New_York',
                timezoneOptions: [
                    { text: 'EST - Eastern Standard Time (-05:00)', value: 'America/New_York' },
                    { text: 'CST - Central Standard Time (-06:00)', value: 'America/Chicago' },
                    { text: 'MST - Mountain Standard Time (-07:00)', value: 'America/Denver' },
                    { text: 'PST - Pacific Standard Time (-08:00)', value: 'America/Los_Angeles' }
                ],
                scheduleOptions: [
                    {
                        label: 'Monday',
                        selected: false,
                        times: [
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                        ]
                    },
                    {
                        label: 'Tuesday',
                        selected: false,
                        times: [
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                        ]
                    },
                    {
                        label: 'Wednesday',
                        selected: false,
                        times: [
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                        ]
                    },
                    {
                        label: 'Thursday',
                        selected: false,
                        times: [
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                        ]
                    },
                    {
                        label: 'Friday',
                        selected: false,
                        times: [
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                          {label: 10, selected: false},
                          {label: 11, selected: false},
                        ]
                    },
                    {
                        label: 'Saturday',
                        selected: false,
                        times: [
                          {label: 12, selected: false},
                          {label: 1, selected: false},
                          {label: 2, selected: false},
                          {label: 3, selected: false},
                          {label: 4, selected: false},
                          {label: 5, selected: false},
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                          {label: 10, selected: false},
                          {label: 11, selected: false},
                        ]
                    },
                    {
                        label: 'Sunday',
                        selected: false,
                        times: [
                          {label: 12, selected: false},
                          {label: 1, selected: false},
                          {label: 2, selected: false},
                          {label: 3, selected: false},
                          {label: 4, selected: false},
                          {label: 5, selected: false},
                          {label: 6, selected: false},
                          {label: 7, selected: false},
                          {label: 8, selected: false},
                          {label: 9, selected: false},
                          {label: 10, selected: false},
                          {label: 11, selected: false},
                        ]
                    },
                ]
            }
        },
        methods: {
          getCheckboxName: function(day, time) {
            return day.toLowerCase() + "_" + time
          },
          submitForm: function () {
            document.getElementById('season3form').submit()
          },
          timeDisplay: function(time) {
            var offset = 0;
            if(this.selectedTz === 'America/Chicago') offset = -1
            if(this.selectedTz === 'America/Denver') offset = -2
            if(this.selectedTz === 'America/Los_Angeles') offset = -3
            // convert to 24 hour format
            if(time < 12) time += 12
            // subtract the offset
            var converted = time + offset
            // convert back to 12 hour format with am/pm
            var ampm = 'pm'
            if(converted > 12) {
              converted -= 12
            } else {
              ampm = 'am'
            }
            return converted + ampm
          },
          selectedTzDisplay: function() {
            return _.find(this.timezoneOptions, {value: this.selectedTz}).text.substr(0,3)
          }
        }
    }
</script>
