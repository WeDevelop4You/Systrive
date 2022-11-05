import Vue from "vue";
import table from "./Table";
import formBase from "../../../base/formBase";
import dataTableBase from "../../../base/dataTableBase";
import {STATE_CREATE} from "../../../../config/RouteState";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        id: null,
        name: null,
        database: null,
        list: [],
    }),

    mutations: {
        initialize(state, data) {
            state.id = data.id
            state.name = data.name
            state.database = data.database
        },

        setList(state, data) {
            state.list = data
        }
    },

    getters: {
        id(state) {
            return state.id
        },

        list(state) {
            return state.list
        }
    },

    actions: {
        search({commit}, cms) {
            return app.$api.call({
                url: app.$api.companyRoute('company.cms.search', cms),
                method: "GET",
            }).then((response) => {
                commit('initialize', response.data.data)

                return Promise.resolve();
            })
        },

        list({commit}) {
            app.$api.call({
                url: app.$api.companyRoute('sa.company.cms.list'),
                method: "GET",
            }).then((response) => {
                commit('setList', response.data.data)
            })
        },

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
                    dispatch('create', app.$api.companyRoute('sa.company.cms.create'))
                },
            }

            actions[action.state]()
        }
    },

    modules: {
        table: table,
        form: formBase(),
        dataTable: dataTableBase
    }
}
