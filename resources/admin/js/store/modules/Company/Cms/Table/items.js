import Vue from "vue";
import FormBase from "../../../../base/formBase";
import DataTableBase from "../../../../base/dataTableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        init({commit}, namespace) {
            commit(`${namespace}/setCreate`, {})
        },

        create({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then(() => {
                commit('form/setCreate', {})
            })
        },

        store({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "POST",
                data: getters["form/data"]
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        },

        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then(() => {
                commit('form/setEdit', {})
            })
        },

        update({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "PATCH",
                data: getters["form/data"]
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        },
    },

    modules: {
        form: FormBase(),
        restoreForm: FormBase(),
        dataTable: DataTableBase
    }
}
