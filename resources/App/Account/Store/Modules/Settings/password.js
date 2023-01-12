import Vue from "vue";
import Password from "../../../../../Support/Store/Modules/password";
import FormBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        update({commit, getters, dispatch}, route) {
            commit('form/resetErrors')

            app.$api.call({
                url: route,
                method: "PATCH",
                data: getters['form/data']
            }).then(() => {
                commit('form/resetForm')
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('form/setError', getters["password/error"])
                commit('form/setErrors', getters["password/errors"])
            })
        },
    },

    modules: {
        password: Password,
        form: FormBase({
            isReady: true,
            isEditing: true,
            withoutId: true,
            disableLoader: true,
        })
    }
}
