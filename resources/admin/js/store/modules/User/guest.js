import Vue from 'vue';
import FormBase from "../../base/formBase";
import Password from "../password";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        async login({getters, commit}, additionalDataType) {
            commit('loginForm/resetErrors')
            commit('recoveryCodeForm/resetErrors')
            commit('oneTimePasswordForm/resetErrors')

            let data = Object.assign({}, getters["loginForm/data"])

            switch (additionalDataType) {
                case 'OTP':
                    Object.assign(data, getters['oneTimePasswordForm/data'])
                    break
                case 'RC':
                    Object.assign(data, getters['recoveryCodeForm/data'])
                    break
            }

            await app.$api.getCsrfToken()

            return app.$api.call({
                url: app.$api.route('login'),
                method: "POST",
                data: data
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                if (Object.prototype.hasOwnProperty.call(errors,'password')) {
                    commit('loginForm/setError', true)

                    if (additionalDataType !== undefined) {
                        commit('popups/removeModal', null, {root: true})
                    }
                }

                commit('loginForm/setErrors', errors)
                commit('recoveryCodeForm/setErrors', errors)
                commit('oneTimePasswordForm/setErrors', errors)

                return Promise.reject()
            })
        },

        async sendEmail({commit, getters}) {
            commit('passwordRecoveryForm/resetErrors')

            await app.$api.getCsrfToken()

            app.$api.call({
                url: app.$api.route('password.recovery'),
                method: "POST",
                data: getters['passwordRecoveryForm/data'],
            }).catch((error) => {
                let errors = error.response.data.errors || {}

                commit('passwordRecoveryForm/setErrors', errors)
            })
        },

        async resetPassword({commit, getters, dispatch}) {
            commit('resetPasswordForm/resetErrors')

            await app.$api.getCsrfToken()

            app.$api.call({
                url: app.$api.route('reset.password'),
                method: "POST",
                data: getters['resetPasswordForm/data'],
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('resetPasswordForm/setError', getters["password/error"])
                commit('resetPasswordForm/setErrors', getters["password/errors"])
            })
        }
    },

    modules: {
        password: Password,
        loginForm: FormBase({
            disableLoader: true
        }),
        recoveryCodeForm: FormBase({
            isReady: true,
            disableLoader: true
        }),
        resetPasswordForm: FormBase({
            disableLoader: true
        }),
        oneTimePasswordForm: FormBase({
            isReady: true,
            disableLoader: true
        }),
        passwordRecoveryForm: FormBase({
            disableLoader: true
        }),
    }
}
