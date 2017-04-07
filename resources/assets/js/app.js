
require('./bootstrap');

import Vuex from 'vuex'
// import VueResource from 'vue-resource'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.component('schedule', require('./components/Schedule.vue'));
Vue.component('teamselecter', require('./components/TeamSelecter.vue'));
Vue.component('dataloader', require('./components/DataLoader.vue'));
Vue.component('partybar', require('./components/PartyBar.vue'));
Vue.component('partylobby', require('./components/PartyLobby.vue'));
Vue.component('season3reg', require('./components/Season3Registration.vue'));
Vue.component('messages', require('./components/Messages.vue'));
Vue.component('conversations', require('./components/Conversations.vue'));
Vue.use(Vuex)
Vue.use(VueAxios, axios)

const store = new Vuex.Store({
  state: {
    loggedIn: false,
    csrfToken: '',
    userid: 0,
    party: {}
  },
  mutations: {
    setUserstate (state, userstate) {
      state.userid = userstate.userid
      state.party = userstate.party
      state.loggedIn = userstate.loggedIn
    },
    setCsrfToken (state, token) {
      state.csrfToken = token
    },
    addParty (state, data) {
      state.party = data.party
      state.party.creator = data.creator
    },
    clearParty (state) {
      state.party = {}
    }
  }
})

const app = new Vue({
    el: '#app',
    store,
    methods: {
      getState: function() {
        this.$http.get('/userstate').then(response => {
          // success
          console.log(response)
        }, response => {
          // error
          console.log(response)
        })
      }
    }
});

// set up websocket listeners

$(function() {

    $(document).foundation();

    $('.nav-toggle').click(function(e) {
        e.preventDefault();
        // get child subnav
        var subnav = $(this).siblings('.subnav');
        // hide any other subnavs
        $('.subnav').not(subnav).hide();
        //toggle the selected subnav
        subnav.toggle();
        e.stopPropagation();
    });

    $('html').click(function() {
        $('.subnav').hide();
    });

    // stop propagations!
    $('.subnav').click(function(e){
        e.stopPropagation();
    });
});

// Echo.join('chat.1')
//   .here((users) => {
//     console.log(users)
//   })
//   .joining((user) => {
//     console.log(user.name);
//   })
//   .leaving((user) => {
//     console.log(user.name);
//   });
