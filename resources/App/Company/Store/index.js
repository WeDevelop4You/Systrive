import Vue from "vue";
import {Store, install} from "vuex";

Vue.use(install)

// Modules
import FormBase from "../../../Support/Store/Base/formBase";

import Cms from "./Cms";
import dns from "./System/dns";
import domain from "./System/domain";
import database from "./System/database";
import mailDomain from "./System/mail_domain";

import Roles from "../../../Support/Store/Modules/Company/roles";
import Users from "../../../Support/Store/Modules/Company/users";

import OverviewBase from "../../../Support/Store/Base/overviewBase";

const app = Vue.prototype

export default new Store({
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
        initialize({commit}, name) {
            commit('navigation/setMain', [])

            return app.$api.call({
                url: app.$api.route('company.initialize', name),
                method: "GET",
            }).then((response) => {
                commit('initialize', response.data.data)
            })
        },

        complete({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET",
            }).then(() => {
                commit('form/setCreate', {})
            })
        },

        update({getters, commit}, route) {
            return app.$api.call({
                url: route,
                method: "PATCH",
                data: getters['form/data']
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        }
    },

    modules: {
        form: FormBase({
            isReady: true,
            withoutId: true,
            disableLoader: true,
        }),
        switcher: OverviewBase(),

        cms: Cms,
        users: Users,
        roles: Roles,

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
})
