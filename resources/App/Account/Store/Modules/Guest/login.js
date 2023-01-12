import Vue from "vue";
import FormBase from "../../../../../Support/Store/Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    mutations: {
        reset(state) {
            state.form.data.one_time_password = ''
        }
    },

    actions: {
        send({getters, commit}, route) {
            commit('form/resetErrors')

            return app.$api.call({
                url: route,
                method: "POST",
                data: getters["form/data"]
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                if (Object.prototype.hasOwnProperty.call(errors, 'password')) {
                    commit('form/setError', true)

                    if (route.endsWith('one_time_password') || route.endsWith('recovery_code')) {
                        commit('popups/removeModal', null, {root: true})
                    }
                }

                commit('form/setErrors', errors)

                return Promise.reject()
            })
        }
    },

    modules: {
        form: FormBase({
            isReady: true,
            disableLoader: true
        }),
        recoveryCodeForm: FormBase({
            isReady: true,
            disableLoader: true
        }),
        oneTimePasswordForm: FormBase({
            isReady: true,
            disableLoader: true
        }),
    }
}
