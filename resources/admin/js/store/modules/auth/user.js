import Vue from 'vue';

import Companies from './companies'

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
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
            return {
                email: state.email,
                verified: state.verified,
                emailVerifiedAt: state.emailVerifiedAt,
            }
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
                url: '/logout',
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
