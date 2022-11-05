import Vue from "vue";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        component: {}
    }),

    mutations: {
        setComponent(state, component) {
            state.component = component
        },
    },

    getters: {
        component(state) {
            return state.component
        }
    },

    actions: {
        component({commit}, route) {
            commit('setComponent', {})

            app.$api.call({
                url: route,
                method: 'GET'
            }).then((response) => {
                commit('setComponent', response.data.component || {})
            }).catch(() => {
                commit('setComponent', {})
            })
        }
    }
}
