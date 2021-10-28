import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        selected: {
            id: 0,
            name: '',
            email: '',
            domain: '',
            information: '',
        }
    }),

    mutations: {
        setCompany(state, company) {
            state.selected.id = company.id
            state.selected.name = company.name
            state.selected.email = company.email
            state.selected.domain = company.domain
            state.selected.information = company.information
        }
    },

    getters: {
        selected(state) {
            return state.selected
        },
    },

    actions: {
        getOne({commit, rootState}, name) {
            let company = rootState.navigation.companies.find(company => company.name === name) ?? {id: 0}

            app.$api.call({
                url: app.$api.route('user.company.show', company.id),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)
                commit('navigation/setCompanyMenuItems', null, {root: true})
            })
        },
    },
}
