import Vue from "vue";
import FormBase from "../../base/formBase";
import Password from "../password";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        step: 1,
    }),

    mutations: {
        setStep(state, value) {
            state.step = value
        }
    },

    getters: {
        step(state) {
            return state.step
        },
    },

    actions: {
        nextProfile({commit, getters, dispatch}) {
            commit('form/resetErrors')

            const data = getters['form/data']

            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('registration.validation.password'),
                    method: "POST",
                    data: {
                        password: data.password,
                        password_confirm: data.password_confirm,
                    },
                }).then(() => {
                    commit('setStep', 2)
                }).catch((error) => {
                    dispatch('password/errors', error.response.data.errors || {})

                    commit('form/setError', getters['password/error'])
                    commit('form/setErrors', getters['password/errors'])
                })
            });
        },

        nextAccept({commit, getters, dispatch}) {
            commit('form/resetErrors')

            const data = getters['form/data']

            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('registration.validation.profile'),
                    method: "POST",
                    data: {
                        first_name: data.first_name,
                        middle_name: data.middle_name,
                        last_name: data.last_name,
                        gender: data.gender,
                        birth_date: data.birth_date,
                    }
                }).then(() => {
                    commit('setStep', 3)
                }).catch((error) => {
                    dispatch('password/errors', error.response.data.errors || {})

                    commit('form/setError', getters['password/error'])
                    commit('form/setErrors', getters['password/errors'])
                })
            })
        },

        send({commit, getters, dispatch}) {
            commit('form/resetErrors')

            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('registration'),
                    method: "POST",
                    data: getters['form/data']
                }).catch((error) => {
                    dispatch('password/errors', error.response.data.errors || {})

                    commit('form/setError', getters['password/error'])
                    commit('form/setErrors', getters['password/errors'])
                })
            })
        }
    },

    modules: {
        form: FormBase,
        password: Password
    }
}
