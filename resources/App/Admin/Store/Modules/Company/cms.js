import Vue from "vue";
import formBase from "../../../../../Support/Store/Base/formBase";
import {STATE_CREATE} from "../../../../../Support/Config/RouteState";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        create({commit}, route) {
            app.$api.call({
                url: route,
                method: 'GET'
            }).then((response) => {
                commit('form/setCreate', response.data.data)
            })
        },

        store({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((error) => {
                commit("form/setErrors", error.response.data.errors)

                return Promise.reject()
            })
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_CREATE]: () => {
                    dispatch('create', app.$api.companyRoute('admin.company.cms.create'))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: formBase(),
    }
}
