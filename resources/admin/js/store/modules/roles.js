import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        all: []
    }),

    mutations: {
        setRoles(state, roles) {
            state.all = roles
        }
    },

    getters: {

    },

    actions: {
        get({commit}) {
            app.$api.call({
                url: app.$api.route('role.all'),
                method: "GET"
            }).then((response) => {
                commit('setRoles', response.data.data)
            })
        }
    },
}
