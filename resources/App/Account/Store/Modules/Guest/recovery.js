import Vue from "vue";
import FormBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        send({commit, getters}, route) {
            app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data'],
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})
            })
        },
    },

    modules: {
        form: FormBase({
            isReady: true,
            disableLoader: true
        }),
    }
}
