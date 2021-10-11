import Vue from 'vue';
import tableDialog from "./tableDialog";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        all: [],
        selected: {
            email: '',
            fullName: '',
            verified: false,
            emailVerifiedAt: '',
            createdAt: ''
        },
    }),

    mutations: {
        setAccounts(state, accounts) {
            state.all = accounts
        },
    },

    getters: {
        all(state) {
            return state.all
        },

        selected(state) {
            return state.selected
        },
    },

    actions: {
        getAccount() {

        },

        destroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.destroy', state.tableDialog.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },

        forceDestroy({state, commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.destroy.force', state.tableDialog.deleteId),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        }
    },

    modules: {
        tableDialog: tableDialog
    }
}
