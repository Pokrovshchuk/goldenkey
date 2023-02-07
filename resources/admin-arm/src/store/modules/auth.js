import Vue from 'vue'
import axios from 'axios'

const initialState = {
  authenticated: false,
  token: null,
  error: null,
  hallId: null,
}

export default {
  state: () => initialState,

  mutations: {
    setAuth(state, payload) {
      state.authenticated = payload.authenticated
      state.token = payload.token
      state.hallId = payload.hall_id
    },
    setError(state, payload) {
      state.error = payload.error
    },
    removeError(state) {
      state.error = null
    },
    logout(state) {
      state.authenticated = false
      state.token = ''
      state.hallId = null
    },
  },

  actions: {
    async authenticate({ commit, dispatch }, payload) {
      let resp
      try {
        resp = await axios.post('/login', {
          name: payload.name,
          password: payload.password,
        })

        if (resp?.data?.status === 'error' || resp?.status === 'error') {
          commit('setError', { error: resp.data })
          for (const channel in Vue.prototype.$echo.connector.channels) {
            Vue.prototype.$echo.leave(channel);
          }
        } else {
          commit('setAuth', {
            authenticated: true,
            token: 'Bearer ' + resp.data.token,
          })
          axios.defaults.headers.common['authorization'] =
            'Bearer ' + resp.data.token
            dispatch('fetchHallData')
        }
      } catch (e) {
        console.error(e)
        commit('setError', { error: e.response.data })
      }
    },
    async logout({ commit }) {
      let resp
      try {
        resp = await axios.post('logout')
        if (resp.status === 200) {
          commit('logout')
          commit('clearAllNotes')
          axios.defaults.headers.common['authorization'] = ''
          for (const channel in Vue.prototype.$echo.connector.channels) {
            Vue.prototype.$echo.leave(channel);
          }
          
        }
      } catch (e) {
        console.error(e)
      }
    },
  },

  getters: {
    authenticated: (s) => s.authenticated,
    error: (s) => s.error,
    token: (s) => s.token,
  },
}
