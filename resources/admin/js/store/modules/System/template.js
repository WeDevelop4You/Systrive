import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        list: [],
    }),

    mutations: {
        setList(state, data) {
            state.list = data
        }
    },

    getters: {
        list(state) {
            return state.list
        }
    },

    actions: {
        getList({commit}, type) {
            commit('setList', [])

            app.$api.call({
                url: app.$api.route('system.templates.list', type),
                method: "GET"
            }).then((response) => {
                commit('setList', response.data.data)
            })
        }
    }
}
