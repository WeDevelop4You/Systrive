import Vue from 'vue';

import dataTableBase from "../base/dataTableBase";

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
        create({commit, rootGetters}, data) {
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

        async resendInvite({rootGetters}, id) {
            await app.$api.call({
                url: app.$api.route('company.user.invite.resend', rootGetters["company/id"], id),
                method: "POST"
            })
        },

        destroy({state, commit, rootGetters}) {
            app.$api.call({
                url: app.$api.route('company.user.revoke', rootGetters["company/id"], state.dataTable.delete.id),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },
    },

    modules: {
        dataTable: dataTableBase
    }
}
