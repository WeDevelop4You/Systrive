import Vue from 'vue';

import cms from "./Cms";
import users from "./users";
import roles from "./roles";
import dns from "./System/dns";
import domain from "./System/domain";
import FormBase from "../../base/formBase";
import database from "./System/database";
import mailDomain from "./System/mail_domain";

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

        systemId(state) {
            return state.systemId

        }
    },

    actions: {
        async search({commit, dispatch}, name) {
            await app.$api.call({
                url: app.$api.route('company.search', name),
                method: "GET",
            }).then((response) => {
                const data = response.data.data;

                commit('initialize', data)
                dispatch("navigation/company", data.id, {root: true})
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
        cms: cms,
        users: users,
        roles: roles,
        form: FormBase(),

        system: {
            namespaced: true,

            modules: {
                dns: dns,
                domain: domain,
                database: database,
                mailDomain: mailDomain,
            }
        },
    }
}
