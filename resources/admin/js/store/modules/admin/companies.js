import Vue from 'vue';
import tableBase from "../tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        selected: {},
    }),

    mutations: {

    },

    getters: {
        selected(state) {
            return state.selected
        },
    },

    actions: {
        getCompany() {

        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.company', state.tableBase.deleteId),
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
