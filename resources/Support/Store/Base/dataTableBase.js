import Vue from "vue";
import {arrayMoveMutable} from "array-move";

const app = Vue.prototype

export default (options) => {
    return {
        namespaced: true,

        state: () => ({
            items: [],
            headers: [],
            customItems: [],
            meta: {
                total: -1,
                params: {},
                routes: options.routes,
            },
        }),

        mutations: {
            setItemRoute(state, route) {
                state.meta.routes.items = route
            },

            setParams(state, params) {
                state.meta.params = params
            },

            setHeaders(state, data) {
                state.headers = data.headers
                state.customItems = data.customItems
            },

            setItems(state, items) {
                state.items = items
            },

            addItem(state, data) {
                state.items.push(data)
            },

            addItemAtIndex(state, {data, index}) {
                state.items.splice(index, 0, data);
            },

            replaceItem(state, {data, index}) {
                state.items.splice(index, 1, data);
            },

            replaceItemAtIndex(state, {data, originalIndex, index}) {
                state.items[originalIndex] = data;

                arrayMoveMutable(state.items, originalIndex, index)
            },

            deleteItem(state, index) {
                state.items.splice(index, 1)
            },

            setTotal(state, total) {
                state.meta.total = total
            },

            resetParams() {
                options.resetCallback.call(this)
            },

            reset(state) {
                state.items = []
                state.headers = []
                state.customItems = []
                state.meta.total = -1
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
                return app.$api.call({
                    url: state.meta.routes.headers,
                    method: "GET"
                }).then((response) => {
                    commit('setHeaders', response.data)
                })
            },

            getItems({state, commit}, silence = false) {
                return app.$api.call({
                    url: state.meta.routes.items,
                    method: "GET",
                    params: state.meta.params,
                    silence: silence
                }).then((response) => {
                    const data = response.data.data

                    commit('setItems', data.items)
                    commit('setTotal', data.meta.total)
                })
            },

            reset({commit, dispatch}) {
                commit('reset')
                dispatch('getHeaders')
                commit('resetParams')
            }
        }
    }
}
