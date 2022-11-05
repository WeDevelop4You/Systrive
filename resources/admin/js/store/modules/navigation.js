import Vue from 'vue'

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        sub: {},
        main: {},
    }),

    mutations: {
        setMain(state, data) {
            state.main = data
        },

        setSub(state, data) {
            state.sub = data
        },
    },

    getters: {
        main(state) {
            return state.main
        },

        sub(state) {
            return state.sub
        },
    },

    actions: {
        main({commit}) {
            commit('setMain', {})

            app.$api.call({
                url: app.$api.route('navigation.main'),
                method: "GET",
            }).then((response) => {
                commit("setMain", response.data.component || {})
            })
        },

        company({commit}, id) {
            commit('setMain', {})

            app.$api.call({
                url: app.$api.route('company.navigation', id),
                method: "GET"
            }).then((response) => {
                commit("setMain", response.data.component || {})
            })
        },

        sub({commit}) {
            app.$api.call({
                url: app.$api.route('navigation.sub'),
                method: "GET",
            }).then((response) => {
                commit("setSub", response.data.component || {})
            })
        },
    },
}
