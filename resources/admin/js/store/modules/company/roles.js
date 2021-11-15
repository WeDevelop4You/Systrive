import Vue from "vue";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        listItems: [],
    }),

    mutations: {
        setItems(state, items) {
            state.items = items
        },

        setListItems(state, listItems) {
            state.listItems = listItems
        },
    },

    getters: {
        items(state) {
            return state.items
        },

        listItems(state) {
            return state.listItems
        }
    },

    actions: {
        dropList({commit, rootGetters}) {
            app.$api.call({
                url: app.$api.route('company.role.list', rootGetters["company/id"]),
                method: "GET",
            }).then((response) => {
                commit('setListItems', response.data.data)
            })
        }
    }
}
