import Vue from 'vue';

import Users from "./users";
import Roles from "./roles";
import domain from "./system/domain";

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
            system_id: 0,
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

        system(state) {
            return {
                companyId: state.data.id,
                systemId: state.data.system_id
            }
        }
    },

    actions: {
        async search({commit, dispatch}, name) {
            await app.$api.call({
                url: app.$api.route('company.search', name),
                method: "GET"
            }).then((response) => {
                const data = response.data.data;

                commit('setCompany', data)
                dispatch("navigation/getCompanyMenuItems", data.id, {root: true})
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
        roles: Roles,
        domain: domain,
    }
}
