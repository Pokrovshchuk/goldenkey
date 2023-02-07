import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import '../public/scss/style.scss'
import SvgIcon from './components/SvgIcon.vue'
import TimerToggler from './components/TimerToggler.vue'
import Timer from './components/Timer.vue'
import Guest from './components/Guest.vue'
import Note from './components/Note.vue'
import moment from 'moment-timezone'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import VueEcho from 'vue-echo-laravel'
import Pusher from 'pusher-js'
import VueSocialSharing from 'vue-social-sharing'

const getHost = () => window.location.protocol + '//' + window.location.hostname

Vue.use(VueSocialSharing)

window.Pusher = Pusher

Vue.use(VueEcho, {
  broadcaster: 'pusher',
  key: process.env.VUE_APP_PUSHER_KEY,
  cluster: 'eu',
  forceTLS: true,
  authEndpoint: getHost() + '/broadcasting/auth',
  auth: {
    headers: {
      Authorization: store.getters['token'],
    },
  },
})


Vue.config.productionTip = false
Vue.config.devtools = true

axios.defaults.withCredentials = true
axios.defaults.baseURL = getHost() + '/api' || 'api'
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'
axios.defaults.headers.common['Access-Control-Allow-Credentials'] = 'true'
axios.defaults.headers.common['authorization'] = store.getters['token']

Vue.prototype.$axios = axios
Vue.prototype.$eventBus = new Vue()
Vue.prototype.$moment = moment
Vue.prototype.$moment.tz.setDefault('Etc/GMT+0')

Vue.component('SvgIcon', SvgIcon)
Vue.component('TimerToggler', TimerToggler)
Vue.component('Timer', Timer)
Vue.component('Guest', Guest)
Vue.component('Note', Note)
Vue.component('DatePicker', DatePicker)

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#app')
