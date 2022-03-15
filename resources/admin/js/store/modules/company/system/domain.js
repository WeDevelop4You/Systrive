import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {
            list_details: [],
        },
        chartData: {
            data: {},
            labels: [],
        },
    }),

    mutations: {
        setData(state, data) {
            state.data = data
        },

        setChartData(state, data) {
            state.chartData = data
        },

        reset(state) {
            state.data = {}
            state.chartData.data = {}
        }
    },

    getters: {
        data(state) {
            return state.data
        },

        chartData(state) {
            return state.chartData
        }
    },

    actions: {
        async search({commit, dispatch}, domain) {
            const system = app.$api.getCompanySystemIds()

            await app.$api.call({
                url: app.$api.route('company.domain.search', system.companyId, system.systemId, domain)
            }).then((response) => {
                commit('setData', response.data.data)
                dispatch("getChartData")
            })
        },

        getChartData({state, commit}) {
            const system = app.$api.getCompanySystemIds()

            app.$api.call({
                url: app.$api.route('company.domain.usage', system.companyId, system.systemId, state.data.id)
            }).then((response) => {
                commit('setChartData', response.data.data)
            })
        },
    }
}
