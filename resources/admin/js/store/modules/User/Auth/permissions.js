import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        items: [],
        type: 'main',
    }),

    mutations: {
        setItems(state, permissions) {
            state.items = permissions
        },

        changeType(state, type) {
            state.type = type
        },
    },

    getters: {
        getItems(state) {
            return state.items
        }
    },

    actions: {
        getDefault({commit}) {
            if (app.$auth.cannot(app.$config.permissions.superAdmin)) {
                app.$api.call({
                    url: app.$api.route('auth.user.permissions'),
                    method: "GET"
                }).then((response) => {
                    commit("setItems", response.data.data)
                })
            }

            commit('changeType', app.$config.permissions.types.default)
        },

        getCompany({commit, rootGetters}) {
            const companyId = rootGetters['company/id']

            if (app.$auth.cannot(app.$config.permissions.superAdmin) && companyId) {
                app.$api.call({
                    url: app.$api.companyRoute('company.user.permissions'),
                    method: "GET"
                }).then((response) => {
                    commit("setItems", response.data.data)
                })
            }

            commit('changeType', app.$config.permissions.types.company)
        },
    }
}
