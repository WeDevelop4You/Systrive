import Vue from "vue";
import OverviewBase from "../../Base/overviewBase";
import FormBase from "../../Base/formBase";
import Password from "../../password";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        refresh({dispatch}, page) {
            dispatch(
                'page/component',
                app.$api.route('account.settings.overview.page', page)
            )
        },

        updatePassword({commit, getters, dispatch}, route) {
            commit('passwordForm/resetErrors')

            app.$api.call({
                url: route,
                method: "PATCH",
                data: getters['passwordForm/data']
            }).then(() => {
                commit('passwordForm/resetForm')
            }).catch((error) => {
                dispatch('password/errors', error.response.data.errors || {})

                commit('passwordForm/setError', getters["password/error"])
                commit('passwordForm/setErrors', getters["password/errors"])
            })
        },

        createOneTimePassword({commit}, route) {
            app.$api.call({
                url: route,
                method: "GET"
            }).then((response) => {
                commit('oneTimePassword/setData', response.data.data)
            })
        },

        validateOneTimePassword({commit, getters}) {
            const data = getters['oneTimePassword/data']

            commit('oneTimePassword/resetErrors')

            app.$api.call({
                url: app.$api.route('account.settings.otp.validate'),
                method: "POST",
                data: {
                    one_time_password: data.oneTimePassword
                }
            }).then(() => {
                commit('oneTimePassword/resetForm')
                commit('popups/removeModal', null, {root: true})
            }).catch((error) => {
                commit('oneTimePassword/setErrors', error.response.data.errors || {})
            })
        },
    },

    modules: {
        page: OverviewBase,
        password: Password,
        navigation: OverviewBase,
        passwordForm: FormBase({
            isEditing: true,
            disableLoader: true,
        }),
        oneTimePassword: FormBase({
            disableLoader: true,
        })
    }
}
