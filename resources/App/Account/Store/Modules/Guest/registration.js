import Vue from "vue";
import FormBase from "../../../../../Support/Store/Base/formBase";
import Password from "../../../../../Support/Store/Modules/password";
import StepperBase from "../../../../../Support/Store/Base/stepperBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        nextProfile({commit, getters, dispatch}, route) {
            commit('form/resetErrors')

            const data = getters['form/data']

            app.$api.call({
                url: route,
                method: "POST",
                data: {
                    password: data.password,
                    password_confirm: data.password_confirm,
                },
            }).then(() => {
                commit('stepper/next')
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('form/setError', getters['password/error'])
                commit('form/setErrors', getters['password/errors'])
            })
        },

        nextAccept({commit, getters, dispatch}, route) {
            commit('form/resetErrors')

            const data = getters['form/data']

            app.$api.call({
                url: route,
                method: "POST",
                data: {
                    first_name: data.first_name,
                    middle_name: data.middle_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    birth_date: data.birth_date,
                }
            }).then(() => {
                commit('stepper/next')
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('form/setError', getters['password/error'])
                commit('form/setErrors', getters['password/errors'])
            })
        },

        send({commit, getters, dispatch}, route) {
            commit('form/resetErrors')

            app.$api.call({
                url: route,
                method: "POST",
                data: getters['form/data']
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('form/setError', getters['password/error'])
                commit('form/setErrors', getters['password/errors'])
            })
        }
    },

    modules: {
        form: FormBase({
            isReady: true,
            disableLoader: true,
        }),
        stepper: StepperBase(),
        password: Password
    }
}
