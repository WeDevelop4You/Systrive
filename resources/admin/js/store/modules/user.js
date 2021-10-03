import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: 0,
        email: '',
        verified: false,
        emailVerifiedAt: '',
    }),

    mutations: {
        setUser(state, user) {
            state.id = user.id
            state.email = user.email
            state.emailVerifiedAt = user.email_verified_at
            state.verified = user.email_verified_at !== null
        }
    },

    getters: {
        get(state) {
            return state
        },
    },

    actions: {
        get({commit}) {
            app.$api.call({
                url: app.$api.route('auth.user'),
                method: "GET"
            }).then((response) => {
                commit('setUser', response.data)
            })
        },

        logout() {
            app.$api.call({
                url: app.$api.route('logout'),
                method: "GET",
            }).then((response) => {
                window.location.href = response.data.redirect
            })
        },
    },

    module: {

    }
}
