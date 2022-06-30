import Vue from 'vue';
import OverviewBase from "../../Base/overviewBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {}
    }),

    mutations: {
        setData(state, data) {
            state.data = data;
        },
    },

    getters: {
        data(state) {
            return state
        }
    },

    actions: {
        async search({commit}, database) {
            const identifiers = app.$api.getIdentifiers()

            await app.$api.call({
                url: app.$api.route('system.database.search', identifiers.company, identifiers.system, database)
            }).then((response) => {
                commit('setData', response.data.data)
                commit('overview/setComponent', response.data.component)
            })
        },
    },

    modules: {
        overview: OverviewBase
    }
}
