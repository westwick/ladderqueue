import Vue from 'vue'
import Router from 'vue-router'
import News from '../components/News'
import About from '../components/About'
import Leaderboard from '../components/Leaderboard'
import GameDraft from '../components/GameDraft'
import LadderGame from '../components/LadderGame'
import Games from '../components/Games'
import Settings from '../components/Settings'
import PlayerLog from '../components/PlayerLog'
import PlayerProfile from '../components/PlayerProfile'
import OnlineUsers from '../components/OnlineUsers'
import Admin from '../components/Admin'
import AdminNews from '../components/AdminNews'
import AdminEditUsers from '../components/AdminEditUsers'
import LiveGames from '../components/LiveGames'

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
      path: '/about',
      name: 'About',
      component: About
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
      path: '/log',
      name: 'PlayerLog',
      component: PlayerLog
    },
    {
      path: '/draft',
      name: 'Draft',
      component: GameDraft
    },
    {
      path: '/players',
      name: 'OnlineUsers',
      component: OnlineUsers
    },
    {
      path: '/u/:username',
      name: 'PlayerProfile',
      component: PlayerProfile,
      props: true
    },
    {
      path: '/games',
      name: 'Games',
      component: Games
    },
    {
      path: '/games/cancelled',
      name: 'CancelledGames',
      component: Games
    },
    {
      path: '/games/live',
      name: 'LiveGames',
      component: LiveGames
    },
    {
      path: '/game/:id',
      name: 'LadderGame',
      component: LadderGame
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/admin/news',
      name: 'AdminNews',
      component: AdminNews
    },
    {
      path: '/admin/users',
      name: 'AdminEditUsers',
      component: AdminEditUsers
    }
  ]
})