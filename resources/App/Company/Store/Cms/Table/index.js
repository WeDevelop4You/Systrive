import Vue from "vue";
import api from "./api";
import items from "./items";
import columns from "./columns";
import formBase from "../../../../../Support/Store/Base/formBase";
import overviewBase from "../../../../../Support/Store/Base/overviewBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setCreate', response.data.data)
            })
        },

        store({commit, getters}, route) {
            const data = getters['form/data']
            const columns = getters['columns/getReIndexedItems']

            return app.$api.call({
                url: route,
                method: "POST",
                data: {...data, columns}
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

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

        update({commit, getters}, route) {
            const data = getters['form/data']
            const columns = getters['columns/getReIndexedItems']

            return app.$api.call({
                url: route,
                method: "PATCH",
                data: {...data, columns}
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        },
    },

    modules: {
        form: formBase(),
        overview: overviewBase(),

        api: api,
        items: items,
        columns: columns
    }
}
