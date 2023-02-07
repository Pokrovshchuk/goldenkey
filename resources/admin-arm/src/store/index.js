import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import certificateStore from './modules/certificate'
import authStore from './modules/auth'
import notifications from './modules/notifications'
import hall from './modules/hall'
import registry from './modules/registry'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    certificateStore,
    authStore,
    notifications,
    hall,
    registry,
  },
  plugins: [
    createPersistedState({
      paths: ['authStore.authenticated', 'authStore.token', 'authStore.hallId'],
    }),
  ],
})
