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
            state.main = data.component
        },

        setSub(state, data) {
            state.sub = data.component
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
            app.$api.call({
                url: app.$api.route('navigation.main'),
                method: "GET",
            }).then((response) => {
                commit("setMain", response.data)
            })
        },

        company({commit}, id) {
            app.$api.call({
                url: app.$api.route('company.navigation', id),
                method: "GET"
            }).then((response) => {
                commit("setMain", response.data)
            })
        },

        sub({commit}) {
            app.$api.call({
                url: app.$api.route('navigation.sub'),
                method: "GET",
            }).then((response) => {
                commit("setSub", response.data)
            })
        },
    },
}
