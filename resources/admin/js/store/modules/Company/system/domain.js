import Vue from 'vue';
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
                url: app.$api.route('system.domain.search', identifiers.company, identifiers.system, domain),
                method: "GET"
            }).then((response) => {
                commit('data', response.data.data)
                commit('overview/setComponent', response.data.component)
            })
        },
    },

    modules: {
        overview: OverviewBase
    }
}
