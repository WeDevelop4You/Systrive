import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        email: '',
        verified: false,
        emailVerifiedAt: '',
        permissions: []
    }),

    mutations: {
        setUser(state, user) {
            state.email = user.email
            state.emailVerifiedAt = user.email_verified_at
            state.verified = user.email_verified_at !== null
        },

        setPermissions(state, permissions) {
            state.permissions = permissions
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

        getPermissions(state) {
            return state.permissions
        }
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

        getPermissions({commit}) {
            app.$api.call({
                url: app.$api.route('auth.user.permissions'),
                method: "GET"
            }).then((response) => {
                commit("setPermissions", response.data.data)
            })
        },

        getCompanyPermissions({commit, rootGetters}) {
            if (app.$auth.cannot('super_admin')) {
                app.$api.call({
                    url: app.$api.route('company.user.permissions', rootGetters['company/id']),
                    method: "GET"
                }).then((response) => {
                    commit("setPermissions", response.data.data)
                })
            }
        },

        logout() {
            app.$api.call({
                url: '/logout',
                method: "GET",
            })
        },
    },
}
