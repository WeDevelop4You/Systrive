import Vue from "vue";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        status: 'loading',

        items: [],
        headers: [],
        customItems: [],
        meta: {
            total: -1,
            params: {},
            routes: {
                items: '',
                headers: '',
            },
        },
    }),

    mutations: {
        setRoutes(state, routes) {
            state.meta.routes = routes
        },

        setItemRoute(state, route) {
            state.meta.routes.items = route
        },

        setParams(state, params) {
            state.status = 'set_params'
            state.meta.params = params
        },

        setBase(state, data) {
            state.status = 'set_base'
            state.headers = data.headers
            state.customItems = data.customItems
        },

        setItems(state, items) {
            state.status = 'set_items'
            state.items = items
        },

        setTotal(state, total) {
            state.meta.total = total
        },

        resetParams(state) {
            state.status = 'reset_params'
        },

        reset(state) {
            state.items = []
            state.meta.total = -1
            state.status = 'loading'
        }
    },

    getters: {
        status(state) {
            return state.status
        },

        headers(state) {
            return state.headers
        },

        customItems(state) {
            return state.customItems
        },

        items(state) {
            return state.items
        },

        total(state) {
            return state.meta.total
        },
    },

    actions: {
        getHeaders({state, commit}) {
            app.$api.call({
                url: state.meta.routes.headers,
                method: "GET"
            }).then((response) => {
                commit('setBase', response.data)
            })
        },

        getItems({state, commit}) {
            app.$api.call({
                url: state.meta.routes.items,
                method: "GET",
                params: state.meta.params
            }).then((response) => {
                const data = response.data.data

                commit('setItems', data.items)
                commit('setTotal', data.meta.total)
            })
        }
    }
}
