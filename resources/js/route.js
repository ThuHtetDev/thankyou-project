import VueRouter from 'vue-router';

  let routes  = [
    { path: '/', meta: { requiresAfterLogin: true }, component: require('./components/auth/Login.vue').default },
    { path: '/login', meta: { requiresAfterLogin: true }, component: require('./components/auth/Login.vue').default },
    { path: '/logout', meta: { requiresAuth: true }, component: require('./components/auth/Logout.vue').default },
    { path: '/play', meta: { requiresAuth: true }, component: require('./components/layouts/Play.vue').default },
    { path: '/chat/detail/:id',name:'chatDetail',  meta: { requiresAuth: true }, component: require('./components/layouts/ChatDetail.vue').default },
    { path: '/random', meta: { requiresAuth: true }, component: require('./components/layouts/Random.vue').default },
    { path: '/chat', meta: { requiresAuth: true }, component: require('./components/layouts/Chat.vue').default },
    { path: '/dashboard', meta: { requiresAuth: true }, component: require('./components/layouts/Dashboard.vue').default },
    { path: '/change-password', meta: { requiresAuth: true }, component: require('./components/layouts/ChangePassword.vue').default },
    { path: '/profile', meta: { requiresAuth: true }, component: require('./components/layouts/Profile.vue').default },
    { path: '/today/match-list', meta: { requiresAuth: true }, component: require('./components/layouts/TodayTalk.vue').default },
    { path: '/testing', meta: { requiresAuth: true }, component: require('./components/ExampleComponent.vue').default },
  ]
  const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes // short for `routes: routes`
  })

  export default router;