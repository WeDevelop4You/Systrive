import Vue from "vue";
import table from "./Table";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: null,
        name: null,
        database: null,
    }),

    mutations: {
        initialize(state, data) {
            state.id = data.id
            state.name = data.name
            state.database = data.database
        },
    },

    getters: {
        id(state) {
            return state.id
        },
    },

    actions: {
        search({commit}, cms) {
            return app.$api.call({
                url: app.$api.companyRoute('company.cms.search', cms),
                method: "GET",
            }).then((response) => {
                commit('initialize', response.data.data)

                return Promise.resolve();
            })
        }
    },

    modules: {
        table: table,
    }
}
