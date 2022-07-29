import Vue from 'vue';
import dataTableBase from "../Base/dataTableBase";
import FormBase from "../Base/formBase";
import ShowBase from "../Base/showBase";

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
                app.$routeLoader.resetForm()
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

        show({commit, dispatch}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                const data = response.data.data

                commit('setShow', data.id)
                commit('company/initialize', data, {root: true})

                dispatch('permissions/getList', null, {root: true})
                dispatch('company/roles/dropList', null, {root: true});
            }).catch(() => {
                commit('resetShow')
            })
        },

        states({dispatch}, action) {
            const actions = {
                new: () => {
                    dispatch('create', app.$api.route('admin.company.invite'))
                },
                edit: () => {
                    dispatch('edit', app.$api.route('admin.company.edit', action.params.id))
                },
                show: () => {
                    dispatch('show', app.$api.route('admin.company.show', action.params.id))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        form: FormBase(),
        show: ShowBase,
        dataTable: dataTableBase
    }
}
