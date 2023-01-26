import Vue from 'vue';

import FormBase from "../../Base/formBase";
import {STATE_CREATE, STATE_EDIT} from "../../../Config/RouteState";

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

        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: 'GET'
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            }).catch(() => {
                app.$state.resetForm()
            })
        },

        update({commit, getters}, route) {
            const data = getters['form/data']

            return app.$api.call({
                url: route,
                method: 'PATCH',
                data: {
                    roles: data.roles,
                    permissions: data.permissions
                }
            }).catch((error) => {
                commit("form/setErrors", error.response.data.errors)

                return Promise.reject()
            })
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_CREATE]: () => {
                    dispatch('create', app.$api.companyRoute('company.user.invite'))
                },
                [STATE_EDIT]: () => {
                    dispatch('edit', app.$api.companyRoute('company.user.edit', action.params.id))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: FormBase(),
    }
}
