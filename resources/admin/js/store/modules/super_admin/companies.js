import Vue from 'vue';
import tableBase from "../tableBase";

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

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.company.destroy', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
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

        async resendInvite(_, id) {
            await app.$api.call({
                url: app.$api.route('admin.company.invite.resend', id),
                method: "POST"
            })
        }
    },

    modules: {
        tableBase: tableBase
    }
}
