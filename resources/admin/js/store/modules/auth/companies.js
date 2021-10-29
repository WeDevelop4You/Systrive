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
        search({commit}, [name, setMenuItems = false]) {
            app.$api.call({
                url: app.$api.route('user.company.search', name),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)

                if (setMenuItems) {
                    commit("navigation/setCompanyMenuItems", null, {root: true})
                }
            })
        },

        getOne({commit}, id) {
            app.$api.call({
                url: app.$api.route('user.company.show', id),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)
            })
        },
    },
}
