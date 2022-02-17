import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        passwordValues: {
            dialog: false,
            current_password: '',
            password: '',
            password_confirm: '',
        },
        twoFAValues: {
            dialog: false,
            step: 1,
            QRCode: '',
            oneTimePassword: '',
        },
        errors: {}
    }),

    mutations: {
        changePasswordDialog(state, value = true) {
            state.passwordValues.dialog = value
        },

        setPasswordValues(state, values) {
            state.passwordValues = values
        },

        clearPasswordValues(state) {
            state.passwordValues = {
                dialog: false,
                current_password: '',
                password: '',
                password_confirm: '',
            }
        },

        changeTwoFADialog(state, value = true) {
            state.twoFAValues.dialog = value
        },

        setTwoFAValues(state, values) {
            state.twoFAValues = values
        },

        setTwoFAQRCode(state, value) {
            state.twoFAValues.QRCode = value
        },

        cleaTwoFAValues(state) {
            state.twoFAValues = {
                dialog: false,
                step: 1,
                QRCode: '',
                oneTimePassword: '',
            }
        },

        setError(state, errors) {
            state.errors = errors;
        }
    },

    getters: {
        passwordValues(state) {
            return state.passwordValues
        },

        twoFAValues(state) {
            return state.twoFAValues
        },

        errors(state) {
            return state.errors
        }
    },

    actions: {
        changePassword({state, commit}) {
            commit('setError', {})

            app.$api.call({
                url: app.$api.route('user.account.change.password'),
                method: "PATCH",
                data: state.passwordValues
            }).then(() => {
                commit('clearPasswordValues')
                commit('changePasswordDialog', false)
            }).catch((error) => {
                commit('setError', error.response.data.errors || {})
            })
        },

        getQRCode({commit}) {
            app.$api.call({
                url: app.$api.route('user.account.2fa.qrcode'),
                method: "GET"
            }).then((response) => {
                commit('setTwoFAQRCode', response.data.data)
            })
        },

        validateTwoFA({state, commit}) {
            commit('setError', {})

            app.$api.call({
                url: app.$api.route('user.account.2fa.validate'),
                method: "POST",
                data: {
                    one_time_password: state.twoFAValues.oneTimePassword
                }
            }).then(() => {
                commit('cleaTwoFAValues')
                commit('changeTwoFADialog', false)
                commit('user/isSecured', true, {root: true})
            }).catch((error) => {
                commit('setError', error.response.data.errors || {})
            })
        },

        disable2FA({commit}) {
            app.$api.call({
                url: app.$api.route('user.account.2fa.disable'),
                method: "DELETE",
            }).then(() => {
                commit('user/isSecured', false, {root: true})
            })
        }
    }
}
