import Vue from "vue";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        items: []
    }),

    mutations: {
        setItems(state, items) {
            state.items = items
        }
    },

    getters: {
        items(state) {
            return state.items
        }
    },

    actions: {
        getList({commit}) {
            app.$api.call({
                url: app.$api.route('permissions'),
                method: "GET"
            }).then((response) => {
                commit('setItems', response.data.data)
            })
        }
    }
}
