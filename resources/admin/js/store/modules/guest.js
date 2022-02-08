import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        error: false,
        errors: {},
    }),

    mutations: {
        setError(state, value) {
            state.error = value;
        },

        setErrors(state, errors) {
            state.errors = errors;
        }
    },

    getters: {
        error(state) {
            return state.error
        },

        errors(state) {
            return state.errors
        }
    },

    actions: {
        login({commit}, data) {
            commit('setErrors', {})
            commit('setError', false)

            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('login'),
                    method: "POST",
                    data: data,
                }).catch((error) => {
                    const errors = error.response.data.errors || {}

                    if (Object.prototype.hasOwnProperty.call(errors,'failed')) {
                        commit('setError', true)
                        commit('setErrors', {password: errors.failed})
                    } else {
                        commit('setErrors', errors)
                    }
                })
            })
        },

        sendEmail({commit}, email) {
            commit('setErrors', {})

            return app.$api.getCsrfToken().then(() => {
                return app.$api.call({
                    url: app.$api.route('password.recovery'),
                    method: "post",
                    data: {
                        email: email
                    },
                }).then(() => {
                    return true
                }).catch((error) => {
                    let errors = error.response.data.errors || {}

                    commit('setErrors', errors)

                    return false
                })
            }).catch(() => {
                return false
            })
        },

        resetPassword({dispatch, commit}, data) {
            commit('setErrors', {})

            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('reset.password'),
                    method: "post",
                    data: data,
                }).catch((error) => {
                    let errors = error.response.data.errors || {}

                    dispatch('passwordError', errors)
                })
            })
        }
    }
}
