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
        resetError({commit}) {
            commit('setError', false)
            commit('setErrors', {})
        },

        passwordError({commit}, errors) {
            let newErrors = {}

            errors.password?.forEach((message) => {
                commit('setError', true)

                if (message.includes('characters')) {
                    newErrors.characters = true
                } else if (message.includes('uppercase')) {
                    newErrors.mixedCase = true
                } else if (message.includes('number')) {
                    newErrors.number = true
                } else if (message.includes('symbol')) {
                    newErrors.symbol = true
                } else {
                    newErrors.password = [
                        ...newErrors.password || [],
                        message
                    ]
                }
            })

            delete errors.password

            commit('setErrors', {
                ...errors,
                ...newErrors
            })
        },

        login({dispatch, commit}, data) {
            dispatch('resetError')

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

        sendEmail({dispatch, commit}, email) {
            dispatch('resetError')

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

        resetPassword({dispatch}, data) {
            dispatch('resetError')

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
