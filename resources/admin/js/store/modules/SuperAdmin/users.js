import Vue from 'vue';
import dataTableBase from "../../base/dataTableBase";

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
        list({commit}) {
            app.$api.call({
                url: app.$api.route('admin.user.list'),
                method: "GET",
            }).then((response) => {
                commit('setList', response.data.data)
            })
        },

        edit(_, route) {
            console.log(route)
        },

        update(_, route) {
            console.log(route)
        }
    },

    modules: {
        dataTable: dataTableBase
    }
}
