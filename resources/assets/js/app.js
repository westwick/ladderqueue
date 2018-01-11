
require('./bootstrap');

import Vuex from 'vuex'
// import VueResource from 'vue-resource'
import axios from 'axios'
import VueAxios from 'vue-axios'
import router from './router'

Vue.component('app', require('./components/App.vue'));
Vue.component('sidebar', require('./components/Sidebar.vue'));
Vue.component('schedule', require('./components/Schedule.vue'));
Vue.component('teamselecter', require('./components/TeamSelecter.vue'));
Vue.component('dataloader', require('./components/DataLoader.vue'));
Vue.component('partybar', require('./components/PartyBar.vue'));
Vue.component('partylobby', require('./components/PartyLobby.vue'));
Vue.component('season3reg', require('./components/Season3Registration.vue'));
Vue.component('playerqueue', require('./components/PlayerQueue.vue'));
Vue.component('messages', require('./components/Messages.vue'));
Vue.component('conversations', require('./components/Conversations.vue'));
Vue.component('convonav', require('./components/ConversationsNavbar.vue'));
Vue.use(Vuex)
Vue.use(VueAxios, axios)

const store = new Vuex.Store({
  state: {
    loggedIn: false,
    is_admin: false,
    csrfToken: '',
    userid: 0,
    username: '',
    canQueue: false,
    settings: [],
    profile: [],
    joinedQueue: 0,
    onlineUsers: [],
    players: [],
    game: '',
    games: [],
    news: null
  },
  mutations: {
    setUserstate (state, userstate) {
      state.userid = userstate.userid
      state.username = userstate.username
      state.joinedQueue = userstate.joinedQueue
      state.party = userstate.party
      state.loggedIn = userstate.loggedIn
      state.canQueue = userstate.canQueue
      state.is_admin = userstate.is_admin
      state.settings = userstate.settings
      state.profile = userstate.profile
    },
    saveSettings(state, settings) {
      state.settings = settings.settings
      state.profile = settings.profile
    },
    setCsrfToken (state, token) {
      state.csrfToken = token
    },
    newGame(state, game) {
      state.game = game
      state.players = []
    },
    updateGame(state, game) {
      state.game = game
    },
    setGamestate(state, data) {
      state.players = data.players
      state.game = data.game
      state.games = data.games
      state.news = data.news
    },
    clearGame(state) {
      state.game = ''
    },
    clearQueueTimer(state) {
      state.joinedQueue = 0
    },
    userReady(state, players) {
      state.game.players = players
    },
    playersUpdated(state, players) {
      state.players = players
    },
    onlineUsers(state, users) {
      state.onlineUsers = users
    },
    gamesUpdated(state, games) {
      state.games = games
    }
  }
})

const app = new Vue({
    el: '#app',
    router,
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
