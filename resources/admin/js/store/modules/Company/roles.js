import Vue from "vue";
import dataTableBase from "../Base/dataTableBase";
import FormBase from "../Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        listItems: [],
    }),

    mutations: {
        setListItems(state, listItems) {
            state.listItems = listItems
        },
    },

    getters: {
        listItems(state) {
            return state.listItems
        }
    },

    actions: {
        dropList({commit, rootGetters}) {
            app.$api.call({
                url: app.$api.route('company.role.list', rootGetters["company/id"]),
                method: "GET",
            }).then((response) => {
                commit('setListItems', response.data.data)
            })
        },

        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) =>  {
                commit('form/setCreate', response.data.data)
            })
        },

        store({commit, dispatch, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("form/setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addNotification', {message: errors.permissions[0]}, {root: true})
                }

                return Promise.reject()
            })
        },

        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            })
        },

        update({commit, dispatch, getters}, route) {
            return app.$api.call({
                url: route,
                method: 'PATCH',
                data: getters['form/data']
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("form/setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addNotification', {message: errors.permissions[0]}, {root: true})
                }

                return Promise.reject()
            })
        },

        states({dispatch, rootGetters}, action) {
            const companyId = rootGetters['company/id']
            const actions = {
                new: () => {
                    dispatch('create', app.$api.route('company.role.create', companyId))
                },
                edit: () => {
                    dispatch('edit', app.$api.route('company.role.edit', companyId, action.params.id))
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
