import Vue from 'vue';

import tableBase from "../tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({

    }),

    mutations: {

    },

    getters: {

    },

    actions: {
        invite({commit, rootGetters}, data) {
            app.$api.call({
                url: app.$api.route('company.user.invite', rootGetters["company/id"]),
                method: "POST",
                data: data
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                commit("setErrors", error.response.data.errors)
            })
        },

        getOne({commit, rootGetters}, id) {
            app.$api.call({
                url: app.$api.route('company.user.edit', rootGetters["company/id"], id),
                method: 'GET'
            }).then((response) => {
                commit('setEdit', response.data.data)
            })
        },

        update({commit, rootGetters}, data) {
            app.$api.call({
                url: app.$api.route('company.user.edit', rootGetters["company/id"], data.id),
                method: 'PATCH',
                data: {
                    roles: data.roles,
                    permissions: data.permissions
                }
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                commit("setErrors", error.response.data.errors)
            })
        },

        revoke({state, commit, rootGetters}) {
            app.$api.call({
                url: app.$api.route('company.user.revoke', rootGetters["company/id"], state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },

        async resendInvite({rootGetters}, id) {
            await app.$api.call({
                url: app.$api.route('company.user.invite.resend', rootGetters["company/id"], id),
                method: "POST"
            })
        }
    },

    modules: {
        tableBase: tableBase
    }
}
