import Vue from 'vue';
import OverviewBase from "../../Base/overviewBase";
import FormBase from "../../Base/formBase";

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
                commit('setData', response.data.data)
                commit('overview/setComponent', response.data.component)
            })
        },

        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            })
        },

        update({commit, getters}, route) {

        }
    },

    modules: {
        form: FormBase({
            withoutId: true
        }),
        overview: OverviewBase
    }
}
