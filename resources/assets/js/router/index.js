import Vue from 'vue'
import Router from 'vue-router'
import News from '../components/News'
import Leaderboard from '../components/Leaderboard'

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
    }
  ]
})