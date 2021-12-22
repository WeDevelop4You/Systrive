import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        email: '',
        verified: false,
        emailVerifiedAt: '',
        permissions: [],
        hasPermission: false,
        hasCompanyPermission: false,
    }),

    mutations: {
        setUser(state, user) {
            state.email = user.email
            state.emailVerifiedAt = user.email_verified_at
            state.verified = user.email_verified_at !== null
        },

        setPermissions(state, permissions) {
            state.permissions = permissions
            state.hasPermission = true
            state.hasCompanyPermission = false
        },

        setCompanyPermissions(state, permissions) {
            state.permissions = permissions
            state.hasCompanyPermission = true
            state.hasPermission = false
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
            if (app.$auth.cannot(app.$config.permissions.superAdmin)) {
                app.$api.call({
                    url: app.$api.route('company.user.permissions', rootGetters['company/id']),
                    method: "GET"
                }).then((response) => {
                    commit("setCompanyPermissions", response.data.data)
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
