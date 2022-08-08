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
            await app.$api.call({
                url: app.$api.companyRoute('system.dns.search', domain)
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
