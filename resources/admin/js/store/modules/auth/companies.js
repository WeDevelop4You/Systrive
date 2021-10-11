import Vue from 'vue';
import Routes from '../../../plugins/routes'

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        navigation: [],
        selected: {
            id: 0,
            name: '',
            email: '',
            domain: '',
            information: '',
        }
    }),

    mutations: {
        setNavigation(state, navigation) {
            state.navigation = navigation;
        },

        setCompany(state, company) {
            state.selected.id = company.id
            state.selected.name = company.name
            state.selected.email = company.email
            state.selected.domain = company.domain
            state.selected.information = company.information
        }
    },

    getters: {
        navigation(state) {
            return state.navigation;
        },

        selected(state) {
            return state.selected
        },
    },

    actions: {
        getNavigation({dispatch, commit}) {
            app.$api.call({
                url: app.$api.route('user.company'),
                method: "GET"
            }).then((response) => {
                const params = Routes.currentRoute.params

                commit('setNavigation', response.data.data)

                if (params.hasOwnProperty('companyName')) {
                    dispatch('get', params.companyName)
                }
            })
        },

        get({commit, state}, name) {
            let company = state.navigation.find(company => company.name === name) ?? {id: 0}

            app.$api.call({
                url: app.$api.route('user.company.show', company.id),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)
            })
        },
    },
}
