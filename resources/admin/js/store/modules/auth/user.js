import Vue from 'vue';
import security from "./settings/security";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        email: '',
        verified: false,
        emailVerifiedAt: '',
        permissions: [],
        hasPermission: false,
        permissionType: 'main',
    }),

    mutations: {
        setUser(state, user) {
            state.email = user.email
            state.emailVerifiedAt = user.email_verified_at
            state.verified = user.email_verified_at !== null
        },

        setPermissions(state, permissions) {
            state.hasPermission = true
            state.permissions = permissions
        },

        changePermissionType(state, type) {
            state.permissionType = type
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
        },

        getPermissionType(state) {
            return state.permissionType
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
            if (app.$auth.cannot(app.$config.permissions.superAdmin)) {
                app.$api.call({
                    url: app.$api.route('auth.user.permissions'),
                    method: "GET"
                }).then((response) => {
                    commit("setPermissions", response.data.data)
                })
            }

            commit('changePermissionType', app.$config.permissions.types.main)
        },

        getCompanyPermissions({commit, rootGetters}) {
            if (app.$auth.cannot(app.$config.permissions.superAdmin)) {
                app.$api.call({
                    url: app.$api.route('company.user.permissions', rootGetters['company/id']),
                    method: "GET"
                }).then((response) => {
                    commit("setPermissions", response.data.data)
                })
            }

            commit('changePermissionType', app.$config.permissions.types.company)
        },

        logout() {
            app.$api.call({
                url: '/logout',
                method: "GET",
            })
        },
    },

    modules: {
        security: security
    }
}
