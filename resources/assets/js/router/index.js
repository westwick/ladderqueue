import Vue from 'vue'
import Router from 'vue-router'
import News from '../components/News'
import Leaderboard from '../components/Leaderboard'
import GameDraft from '../components/GameDraft'

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
      path: '/leaderboard',
      name: 'Leaderboard',
      component: Leaderboard
    },
    {
      path: '/draft',
      name: 'Draft',
      component: GameDraft
    }
  ]
})