import Vue from 'vue';
import security from "./settings/security";
import permissions from "./permissions";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {
            email: '',
            verified: false,
            emailVerifiedAt: '',
            isSecured: false,
        }
    }),

    mutations: {
        setData(state, user) {
            state.data = {
                email: user.email,
                emailVerifiedAt: user.email_verified_at,
                verified: user.email_verified_at !== null,
                isSecured: user.is_secured
            }
        },

        isSecured(state, value = true) {
            state.data.isSecured = value
        }
    },

    getters: {
        data(state) {
            return state.data
        },
    },

    actions: {
        getOne({commit}) {
            app.$api.call({
                url: app.$api.route('auth.user'),
                method: "GET"
            }).then((response) => {
                commit('setData', response.data.data)
            })
        },

        logout() {
            app.$api.call({
                url: '/logout',
                method: "GET",
            })
        },
    },

    modules: {
        security: security,
        permissions: permissions
    }
}
