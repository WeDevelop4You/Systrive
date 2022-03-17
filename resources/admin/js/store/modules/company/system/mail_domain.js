import Vue from 'vue';
import dataTableBase from "../../base/dataTableBase";

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
            state.dataTable.items = []
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
        async search({state, commit, dispatch}, mailDomain) {
            const system = app.$api.getCompanySystemIds()

            await app.$api.call({
                url: app.$api.route('company.mail.domain.search', system.companyId, system.systemId, mailDomain)
            }).then((response) => {
                const data = response.data.data

                commit('setData', data)
                commit('setRoutes', {
                    items: app.$api.route('company.mail.domain.address.table.items', system.companyId, system.systemId, data.id),
                    headers: app.$api.route('company.mail.domain.address.table.headers', system.companyId, system.systemId, data.id)
                })

                if (!state.dataTable.headers.length) {
                    dispatch('getHeaders')
                }

                dispatch("getChartData")
                dispatch('getItems')
            })
        },

        getChartData({state, commit}) {
            const system = app.$api.getCompanySystemIds()

            app.$api.call({
                url: app.$api.route('company.mail.domain.usage', system.companyId, system.systemId, state.id)
            }).then((response) => {
                commit('setChartData', response.data.data)
            })
        },
    },

    modules: {
        dataTable: dataTableBase
    }
}
