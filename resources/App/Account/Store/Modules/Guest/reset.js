import Vue from "vue";
import FormBase from "../../../../../Support/Store/Base/formBase";
import Password from "../../../../../Support/Store/Modules/password";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        send({commit, getters, dispatch}, route) {
            app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data'],
            }).catch((error) => {
                console.error(error)

                dispatch('password/errors', error.response.data.errors || {})

                commit('form/setError', getters["password/error"])
                commit('form/setErrors', getters["password/errors"])
            })
        }
    },

    modules: {
        password: Password,
        form: FormBase({
            isReady: true,
            disableLoader: true
        }),
    }
}
