import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        error: false,
        errors: {},
        credentials: {
            email: '',
            password: '',
            remember: false,
        },
        oneTimePassword: '',
        recoveryCode: '',
    }),

    mutations: {
        setError(state, value) {
            state.error = value;
        },

        setErrors(state, errors) {
            state.errors = errors;
        },

        setCredentials(state, data) {
            state.credentials = data;
        },

        setOneTimePassword(state, data) {
            state.oneTimePassword = data
        },

        setRecoveryCode(state, data) {
            state.recoveryCode = data
        }
    },

    getters: {
        error(state) {
            return state.error
        },

        errors(state) {
            return state.errors
        },

        credentials(state) {
            return state.credentials
        },

        oneTimePassword(state) {
            return state.oneTimePassword
        },

        RecoveryCode(state) {
            return state.recoveryCode
        }
    },

    actions: {
        async login({state, commit}, needsAdditionalData) {
            commit('setErrors', {})
            commit('setError', false)

            let data = Object.assign({}, state.credentials)

            if (needsAdditionalData) {
                needsAdditionalData === 'OTP'
                    ? data.one_time_password = state.oneTimePassword
                    : data.recovery_code = state.recoveryCode
            }

            await app.$api.getCsrfToken()

            return app.$api.call({
                url: app.$api.route('login'),
                method: "POST",
                data: data
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                if (Object.prototype.hasOwnProperty.call(errors,'password')) {
                    commit('setError', true)

                    if (needsAdditionalData) {
                        commit('setOneTimePassword', '')
                        commit('popups/closeModal', null, {root: true})
                    }
                }

                commit('setErrors', errors)

                return Promise.reject()
            })
        },

        async sendEmail({commit}, email) {
            commit('setErrors', {})

            await app.$api.getCsrfToken()

            return app.$api.call({
                url: app.$api.route('password.recovery'),
                method: "post",
                data: {
                    email: email
                },
            }).catch((error) => {
                let errors = error.response.data.errors || {}

                commit('setErrors', errors)

                return Promise.reject()
            })
        },

        async resetPassword({dispatch, commit}, data) {
            commit('setErrors', {})

            await app.$api.getCsrfToken()

            app.$api.call({
                url: app.$api.route('reset.password'),
                method: "post",
                data: data,
            }).catch((error) => {
                let errors = error.response.data.errors || {}

                dispatch('passwordError', errors)
            })
        }
    }
}
