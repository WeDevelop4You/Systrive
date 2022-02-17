import Vue from "vue";
import dataTableBase from "../base/dataTableBase";

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

        create({commit, dispatch, rootGetters}, data) {
            app.$api.call({
                url: app.$api.route('company.role.create', rootGetters["company/id"]),
                method: "POST",
                data: data
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addNotification', {message: errors.permissions[0]}, {root: true})
                }
            })
        },

        getOne({commit, rootGetters}, id) {
            app.$api.call({
                url: app.$api.route('company.role.edit', rootGetters["company/id"], id),
                method: "GET"
            }).then((response) => {
                commit('setEdit', response.data.data)
            })
        },

        update({commit, dispatch, rootGetters}, data) {
            app.$api.call({
                url: app.$api.route('company.role.edit', rootGetters["company/id"], data.id),
                method: 'PATCH',
                data: data
            }).then(() => {
                commit('resetCreateOrEdit')
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit("setErrors", errors)

                if (Object.prototype.hasOwnProperty.call(errors, 'permissions')) {
                    dispatch('popups/addNotification', {message: errors.permissions[0]}, {root: true})
                }
            })
        },

        destroy({state, commit, rootGetters}) {
            app.$api.call({
                url: app.$api.route('company.role.destroy', rootGetters["company/id"], state.dataTable.delete.id),
                method: 'DELETE'
            }).finally(() => {
                commit('resetDelete')
            })
        },
    },

    modules: {
        dataTable: dataTableBase
    }
}
