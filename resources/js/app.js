/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//support vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/store"
const store = new Vuex.Store(
    storeData
 )
// Loading
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
// Init plugin
Vue.use(Loading);
//
import {Picker, Emoji} from 'emoji-mart-vue'

Vue.component('picker', Picker)
Vue.component('emoji', Emoji)
//
// support Vue router
import VueRouter from 'vue-router'
import router from './route'
Vue.use(VueRouter)
//

// ES6 Modules or TypeScript
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});
window.toast = toast;
//

// redirect route 
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.LoggedIn) {
      next({
        path: '/login',
      })
    } else {
      next()
    }
  }else if (to.matched.some(record => record.meta.requiresAfterLogin)) {
    // this route requires no auth
    // if after auth, these should not work
    if (store.getters.LoggedIn) {
      next({
        path: '/play',
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

//

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/auth/Login.vue').default);
Vue.component('sidebar-component', require('./components/layouts/Sidebar.vue').default);
Vue.component('footer-component', require('./components/layouts/Footer.vue').default);

if(store.getters.LoggedIn){
  store.dispatch('currentAuthUserAction');
}


axios.interceptors.response.use(function (response) {
  return response
}, function (error) {
  if (error.response.status === 401) {
    localStorage.removeItem('access_token');
    localStorage.removeItem('auth_user');
    router.push('/login');
  }
  return Promise.reject(error)
})

// Disable Vue Devtool in production
  // Vue.config.devtools = false
  // Vue.config.debug = false
  // Vue.config.silent = true
// end


const app = new Vue({
    store,
    router
  }).$mount('#app')
  window.app = app;
