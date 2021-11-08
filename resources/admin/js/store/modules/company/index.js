import Vue from 'vue';

import Users from "./users";
import Roles from "./roles";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {
            id: 0,
            name: '',
            email: '',
            domain: '',
            information: '',
        }
    }),

    mutations: {
        setCompany(state, company) {
            state.data = company
        }
    },

    getters: {
        id(state) {
            return state.data.id
        },

        data(state) {
            return state.data
        },
    },

    actions: {
        search({commit}, [name, setMenuItems = false]) {
            app.$api.call({
                url: app.$api.route('company.search', name),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)

                if (setMenuItems) {
                    commit("navigation/setCompanyMenuItems", null, {root: true})
                }
            })
        },

        async getOne({commit}, id) {
            await app.$api.call({
                url: app.$api.route('company.show', id),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)
            })
        },
    },

    modules: {
        users: Users,
        roles: Roles
    }
}
