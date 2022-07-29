import Vue from 'vue';

import Users from "./users";
import Roles from "./roles";
import system from "./system";
import FormBase from "../Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: null,
        systemId: null
    }),

    mutations: {
        initialize(state, data) {
            state.id = data.id
            state.systemId = data.system_id
        }
    },

    getters: {
        id(state) {
            return state.id
        },

        identifiers(state) {
            return {
                company: state.id,
                system: state.systemId
            }
        }
    },

    actions: {
        async search({commit, dispatch}, name) {
            await app.$api.call({
                url: app.$api.route('company.search', name),
                method: "GET",
                headers: {
                    'X-Last-Route-Name': app.$lastRoute.name,
                    'X-Last-Route-Path': app.$lastRoute.path,
                }
            }).then((response) => {
                const data = response.data.data;

                commit('initialize', data)
                dispatch("navigation/company", data.id, {root: true})
            }).catch((error) => {
                app.$responseChain(error.response.data)
            })
        },

        async create({getters, commit}, route) {
            return app.$api.call({
                url: route,
                method: "put",
                data: getters['form/data']
            }).catch((error) => {
                commit('setErrors', error.response.data.errors)

                return Promise.reject()
            })
        }
    },

    modules: {
        users: Users,
        roles: Roles,
        system: system,
        form: FormBase(),
    }
}
