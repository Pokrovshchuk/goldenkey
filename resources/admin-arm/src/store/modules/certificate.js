import axios from 'axios'
import Vue from 'vue'

const initialState = {
  code: null,
  message: '',
  status: '',
  certificate: {},
  user: {},
}

export default {
  state: () => initialState,

  mutations: {
    mutateOnSuccess(state, payload) {
      state.status = payload.status
      state.message = payload.message
      state.certificate = payload.certificate
      state.user = payload.user
      Vue.prototype.$eventBus.$emit('certificate-scanned')
    },
    mutateOnError(state, payload) {
      state.certificate = {}
      state.user = {}
      state.status = payload.status ? payload.status : 'error'
      state.code = payload.code ? payload.code : null
      state.message = payload.message ? payload.message : 'Ошибка' 
      Vue.prototype.$eventBus.$emit('certificate-scanned')
    },
    clearStore(state) {
      state.certificate = {}
      state.user = {}
      state.status = ''
      state.code = null
      state.message = ''
    },
  },

  actions: {
    async sendCode({ commit, dispatch }, payload) {
      const resp = await axios.post('certificates-check', payload)

      if (resp?.data?.status === 'success') {
        commit('mutateOnSuccess', resp.data)
        dispatch('fetchHallData')
      } else {
        commit('mutateOnError', resp.data ? resp.data : resp.response.data)
      }
    },
  },

  getters: {
    getCertificate: (s) => s.certificate,
    getCertificateUser: (s) => s.user,
    getCertificateMessage: (s) => s.message,
    getCertificateStatus: (s) => s.status,
    getCertificateCode: (s) => s.code,
  },
}
