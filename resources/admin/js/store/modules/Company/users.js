import Vue from 'vue';

import dataTableBase from "../Base/dataTableBase";
import FormBase from "../Base/formBase";

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
                commit('form/resetForm')
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

        states({dispatch, rootGetters}, action) {
            const companyId = rootGetters['company/id']
            const actions = {
                new: () => {
                    dispatch('create', app.$api.route('company.user.invite', companyId))
                },
                edit: () => {
                    dispatch('edit', app.$api.route('company.user.edit', companyId, action.params.id))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: FormBase(),
        dataTable: dataTableBase
    }
}
