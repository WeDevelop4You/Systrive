import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        all: [],
        dialog: false,
        selected: {
            email: '',
            fullName: '',
            verified: false,
            emailVerifiedAt: '',
            createdAt: ''
        }
    }),

    mutations: {
        setAccounts(state, accounts) {
            state.all = accounts
        },

        setAccount(state, account) {
            state.selected = account
            state.dialog = true
        },

        changeDialog(state, dialog) {
            state.dialog = dialog
        },
    },

    getters: {
        all(state) {
            return state.all
        },

        selected(state) {
            return state.selected
        },

        dialog(state) {
          return state.dialog
        }
    },

    actions: {

    }
}
