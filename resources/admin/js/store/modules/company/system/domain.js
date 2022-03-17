import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: 0,
        name: '',
        listDetails: [],
        chartData: {
            data: {},
            labels: [],
        },
    }),

    mutations: {
        setData(state, data) {
            state.id = data.id
            state.name = data.name
            state.listDetails = data.list_details
        },

        setChartData(state, data) {
            state.chartData = data
        },

        reset(state) {
            state.listDetails = []
            state.chartData.data = {}
        }
    },

    getters: {
        listDetails(state) {
            return state.listDetails
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
                url: app.$api.route('company.domain.usage', system.companyId, system.systemId, state.id)
            }).then((response) => {
                commit('setChartData', response.data.data)
            })
        },
    }
}
