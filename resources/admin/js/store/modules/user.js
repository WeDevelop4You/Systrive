import Vue from 'vue';

import Companies from './user/companies'

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
                commit('setUser', response.data.data)
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

    modules: {
        companies: Companies,
    }
}
