import Vue from 'vue'
import Router from 'vue-router'
import News from '../components/News'
import Leaderboard from '../components/Leaderboard'
import GameDraft from '../components/GameDraft'
import LadderGame from '../components/LadderGame'
import Games from '../components/Games'
import Settings from '../components/Settings'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'News',
      component: News
    },
    {
      path: '/settings',
      name: 'Settings',
      component: Settings
    },
    {
      path: '/leaderboard',
      name: 'Leaderboard',
      component: Leaderboard
    },
    {
      path: '/draft',
      name: 'Draft',
      component: GameDraft
    },
    {
      path: '/games',
      name: 'Games',
      component: Games
    },
    {
      path: '/game/:id',
      name: 'LadderGame',
      component: LadderGame
    }
  ]
})