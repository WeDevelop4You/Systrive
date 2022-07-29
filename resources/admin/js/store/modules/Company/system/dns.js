import Vue from 'vue';
import dataTableBase from "../../Base/dataTableBase";
import OverviewBase from "../../Base/overviewBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {},
    }),

    mutations: {
        setData(state, data) {
            state.data = data
        },
    },

    getters: {
        data(state) {
            return state.data
        },
    },

    actions: {
        async search({commit}, domain) {
            const identifiers = app.$api.getIdentifiers()

            await app.$api.call({
                url: app.$api.route('system.dns.search', identifiers.company, identifiers.system, domain)
            }).then((response) => {
                commit('setData', response.data.data)
                commit('overview/setComponent', response.data.component)
            })
        },
    },

    modules: {
        overview: OverviewBase,
        dataTable: dataTableBase
    }
}
