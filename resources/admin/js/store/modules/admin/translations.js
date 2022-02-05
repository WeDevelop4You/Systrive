import Vue from 'vue';
import tableBase from "../tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        environments: [],
    }),

    mutations: {
        setEnvironments(state, environments) {
            state.environments = environments
        },
    },

    getters: {
        environments(state) {
            return state.environments
        },
    },

    actions: {
        publish() {
            app.$api.call({
                url: app.$api.route('admin.translation.publish'),
                method: "POST"
            })
        },

        getEnvironments({commit}) {
            app.$api.call({
                url: app.$api.route('admin.translations.environments'),
                method: 'GET',
            }).then((response) => {
                commit('setEnvironments', response.data.data)
            })
        },

        getOne({commit}, id) {
            app.$api.call({
                url: app.$api.route('admin.translation', id),
                method: "GET"
            }).then((response) => {
                commit('setEdit', response.data.data)
            })
        },

        update({commit}, data) {
            app.$api.call({
                url: app.$api.route('admin.translation', data.id),
                method: "PATCH",
                data: {
                    translations: data.translations
                }
            }).then(() => {
                commit('resetCreateOrEdit')
            })
        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.translation', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },
    },

    modules: {
        tableBase: tableBase
    }
}
