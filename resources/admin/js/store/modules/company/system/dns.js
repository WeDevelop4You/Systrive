import Vue from 'vue';
import dataTableBase from "../../base/dataTableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: 0,
        name: '',
        listDetails: [],
    }),

    mutations: {
        setData(state, data) {
            state.id = data.id
            state.name = data.name
            state.listDetails = data.list_details
        },

        reset(state) {
            state.listDetails = []
            state.dataTable.items = []
        }
    },

    getters: {
        id(state) {
            return state.id
        },

        listDetails(state) {
            return state.listDetails
        },
    },

    actions: {
        async search({state, commit, dispatch}, domain) {
            const system = app.$api.getCompanySystemIds()

            await app.$api.call({
                url: app.$api.route('company.dns.search', system.companyId, system.systemId, domain)
            }).then((response) => {
                const data = response.data.data

                commit('setData', data)
                commit('setRoutes', {
                    items: app.$api.route('company.dns.record.table.items', system.companyId, system.systemId, data.id),
                    headers: app.$api.route('company.dns.record.table.headers', system.companyId, system.systemId, data.id)
                })

                console.log(state.dataTable.headers)

                if (!state.dataTable.headers.length) {
                    dispatch('getHeaders')
                }

                dispatch('getItems')
            })
        },
    },

    modules: {
        dataTable: dataTableBase
    }
}
