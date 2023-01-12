import Vue from 'vue';
import FormBase from "../../../../Support/Store/Base/formBase";
import ShowBase from "../../../../Support/Store/Base/showBase";
import dataTableBase from "../../../../Support/Store/Base/dataTableBase";
import {STATE_CREATE, STATE_EDIT, STATE_SHOW} from "../../../../Support/Config/RouteState";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({

    }),

    mutations: {

    },

    getters: {

    },

    actions: {
        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET",
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
            return app.$api.call({
                url: route,
                method: 'PATCH',
                data: getters['form/data'],
            }).catch((error) => {
                commit("form/setErrors", error.response.data.errors)

                return Promise.reject()
            })
        },

        show({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                const data = response.data.data

                commit('setShow', data.id)
                commit('company/initialize', data, {root: true})
            }).catch(() => {
                commit('resetShow')
            })
        },

        states({dispatch}, action) {
            const actions = {
                [STATE_CREATE]: () => {
                    dispatch('create', app.$api.route('admin.company.invite'))
                },
                [STATE_EDIT]: () => {
                    dispatch('edit', app.$api.route('admin.company.edit', action.params.id))
                },
                [STATE_SHOW]: () => {
                    dispatch('show', app.$api.route('admin.company.show', action.params.id))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: FormBase(),
        show: ShowBase(),
        dataTable: dataTableBase()
    }
}
