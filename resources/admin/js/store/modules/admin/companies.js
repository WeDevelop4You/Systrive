import Vue from 'vue';
import tableBase from "../tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        owners: []
    }),

    mutations: {
        setOwners(state, data) {
            state.owners = data
        }
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
                data: {
                    ...data,
                    owner: data.owner?.id,
                }
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
                data: {
                    ...data,
                    owner: data.owner?.id,
                }
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

        userList({commit}, search) {
            const params = {}

            if (search) {
                params.search = search
            }

            app.$api.call({
                url: app.$api.route('admin.user.list'),
                method: "GET",
                params: params
            }).then((response) => {
                commit('setOwners', response.data.data)
            })
        },
    },

    modules: {
        tableBase: tableBase
    }
}
