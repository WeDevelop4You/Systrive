import Vue from 'vue';
import dataTableBase from "../base/dataTableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        owners: [],
    }),

    mutations: {
        setOwners(state, data) {
            state.owners = data
        },
    },

    getters: {
        owners(state) {
            return state.owners
        }
    },

    actions: {
        create({commit}, data) {
            commit('resetErrors')

            app.$api.call({
                url: app.$api.route('admin.company.create'),
                method: "POST",
                data: data
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                commit("setErrors", error.response.data.errors)
            })
        },

        getOne({commit}, id) {
            app.$api.call({
                url: app.$api.route('admin.company.edit', id),
                method: 'GET'
            }).then((response) => {
                let data = response.data.data;

                data.removeUser = false;

                commit("setOwners", [data.owner])
                commit('setEdit', data)
            })
        },

        getMany({commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.list'),
                method: "GET",
            }).then((response) => {
                commit('setOwners', response.data.data)
            })
        },

        update({commit}, data) {
            app.$api.call({
                url: app.$api.route('admin.company.edit', data.id),
                method: 'PATCH',
                data: data,
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                commit("setErrors", error.response.data.errors)
            })
        },

        async resendInvite(_, id) {
            await app.$api.call({
                url: app.$api.route('admin.company.invite.resend', id),
                method: "POST"
            })
        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.company.destroy', state.dataTable.delete.id),
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
