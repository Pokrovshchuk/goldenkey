// import axios from 'axios'
import Vue from 'vue'

const initialState = {
    data: null,
    hall: null,
    totalCertificates: 0,
    totalVisits: 0,
}

export default {
    state: () => initialState,

    mutations: {
        setRegistryData(state, payload) {
            state.data = payload.data.certificates
            state.hall = payload.data.hall
            state.totalCertificates = payload.data.certificates.total
            state.totalVisits = payload.data.hall.certificates_sum_pass_limit
        },
    },

    actions: {
        async fetchRegistryData({commit}) {
            let resp
            try {
                resp = await Vue.prototype.$axios.get('/hall/certificates')

                const {data} = resp.data
                commit('setRegistryData', {data})
            } catch (e) {
                if (e.response.status === 401) {
                    commit('logout')
                }
            }
        },
        async filterRegistryData({commit}, payload) {
            let resp
            try {
                resp = await Vue.prototype.$axios.get('/hall/certificates' + payload)

                const {data} = resp.data
                commit('setRegistryData', {data})
            } catch (e) {
                if (e.response.status === 401) {
                    commit('logout')
                }
                console.error(e);
            }
        },
    },

    getters: {
        getRegistryData: (s) => s.data,
        getRegistryName: (s) => (s.hall && s.hall.name ? s.hall.name : ''),
        getRegistryPrefix: (s) => (s.hall && s.hall.prefix ? s.hall.prefix.toUpperCase() : ''),
        getRegistryAdminName: (s) => (s.hall && s.hall.admin_name ? s.hall.admin_name : ''),
        getRegistryId: (s) => (s.hall && s.hall.id ? s.hall.id : ''),
        getRegistryCertificates: (s) => s.data && s.data.data ? s.data.data : [],
        getTotalCertificates: (s) => s.totalCertificates,
        getTotalVisits: (s) => s.totalVisits,
    },
}
