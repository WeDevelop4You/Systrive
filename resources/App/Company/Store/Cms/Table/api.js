import Vue from "vue";
import formBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        edit({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('form/setEdit', response.data.data)
            })
        },

        update({commit, getters}, route) {
            return app.$api.call({
                url: route,
                method: "PATCH",
                data: getters['form/data']
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})

                return Promise.reject()
            })
        }
    },

    modules: {
        form: formBase(),
    }
}