import Vue from 'vue';
import tableBase from "./tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        selected: {
            email: '',
            fullName: '',
            verified: false,
            emailVerifiedAt: '',
            createdAt: ''
        },
    }),

    mutations: {

    },

    getters: {
        selected(state) {
            return state.selected
        },
    },

    actions: {
        getAccount() {

        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.destroy', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },

        forceDestroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.destroy.force', state.tableBase.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        }
    },

    modules: {
        tableBase: tableBase
    }
}
