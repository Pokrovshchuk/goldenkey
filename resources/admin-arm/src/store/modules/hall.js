import Vue from 'vue'


const initialState = {
    data: null,
}

export default {
    state: () => initialState,

    mutations: {
        setHallData(state, payload) {
            state.data = payload.data
        },
        clearHallData(state) {
            state.data = null
        },
    },

    actions: {
        async fetchHallData({commit, dispatch, getters}) {
            let resp
            try {
                resp = await Vue.prototype.$axios.get('/hall')
                const {data} = resp.data

                commit('setHallData', {data})

                if (!Vue.prototype.$echo.options.auth.headers.Authorization) {
                    Vue.prototype.$echo.options.auth.headers.Authorization = getters['token']
                }

                if (!Vue.prototype.$echo.connector.channels[`private-user-events.${resp.data.data.user_id}`]) {
                    Vue.prototype.$echo
                    .private(`user-events.${resp.data.data.user_id}`)
                    .listen('CertificateScannedEvent', (resp) => {
                        resp.message._type = 'scanned'
                        dispatch('addNote', {note: resp.message})

                        if (resp.message.status === 'success') {
                            commit('mutateOnSuccess', resp.message)
                        } else {
                            commit('mutateOnError', resp.message)
                        }
                        
                        dispatch('fetchHallData')
                    })
                    .listen('OrderCreatedEvent', ({order}) => {
                        const orderId = order.id
                        order._type = 'OrderCreatedEvent'
                        dispatch('addNote', {note: order})

                        

                        if (!Vue.prototype.$echo.connector.channels[`private-orders.updated.${orderId}`]) {
                            Vue.prototype.$echo
                            .private(`orders.updated.${orderId}`)
                            .listen('OrderUpdatedEvent', ({order}) => {
                                order._type = 'OrderUpdatedEvent'
                                dispatch('addNote', {note: order})


                                if (order.status === 'completed' || order.status === 'failed') {
                                    if (order.status === 'completed') {
                                        (async ()=> {
                                            await new Promise(resolve => setTimeout(resolve, 4500));
                                            dispatch('fetchHallData')
                                        })()
                                    }

                                    Vue.prototype.$echo.leave(`orders.updated.${orderId}`)
                                }
                            })
                        }
                    })
                } 
            } catch (e) {
                commit('logout')
                console.error(e)
            }


        },
        async sendExpiredCertificate({commit}, payload) {
            try {
                const resp = await Vue.prototype.$axios.post('/certificates-expired', {
                    id: payload.id,
                })

                const {hall} = resp.data

                commit('setHallData', {data: hall})
            } catch (e) {
                console.error(e)
            }
        },
        async removeCertificate({commit}, payload) {
            const resp = await Vue.prototype.$axios.post('/certificates-remove', {
                id: payload.id,
            })

            const {hall} = resp.data

            commit('setHallData', {data: hall})
        },
    },

    getters: {
        getHallData: (s) => s.data,
        getHallName: (s) => (s.data && s.data.name ? s.data.name : ''),
        getHallAdminName: (s) => (s.data && s.data.admin_name ? s.data.admin_name : ''),
        getHallCertificates: (s) =>
            s.data && s.data.certificates ? s.data.certificates : [],
    },
}
