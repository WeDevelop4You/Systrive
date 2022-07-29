import Vue from 'vue';
import settings from "./Settings";
import permissions from "./permissions";
import FormBase from "../../Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        data: {},

        preferences: {},
        preferencesLoaded: false
    }),

    mutations: {
        setData(state, data) {
            state.data = data
        },

        setPreference(state, {type, value}) {
            state.preferences[type] = value
        },

        changeLoadPreferenceStatus(state, value) {
            state.preferencesLoaded = value
        }
    },

    getters: {
        data(state) {
            return state.data
        },

        preferences(state) {
            return state.preferences
        },

        isPreferenceLoaded(state) {
            return state.preferencesLoaded
        }
    },

    actions: {
        getOne({commit}) {
            app.$api.call({
                url: app.$api.route('auth.user'),
                method: "GET"
            }).then((response) => {
                const data = response.data.data

                commit('setData', data)
                commit('form/setEdit', Object.assign({}, data))
            })
        },

        update({commit, getters}) {
            app.$api.call({
                url: app.$api.route('auth.user'),
                method: 'PATCH',
                data: getters['form/data']
            }).catch((error) => {
                commit('form/setErrors', error.response.data.errors || {})
            })
        },

        getPreferences({commit}) {
            commit('changeLoadPreferenceStatus', false)

            app.$api.call({
                url: app.$api.route('account.preferences'),
                method: "GET"
            }).then((response) => {
                const data = response.data.data || {}

                for (const [key, value] of Object.entries(data)) {
                    commit('setPreference', {type: key, value})
                }
            }).finally(() => {
                commit('changeLoadPreferenceStatus', true)
            })
        },

        updatePreferences({state}) {
            app.$api.call({
                url: app.$api.route('account.change.preferences'),
                method: "PATCH",
                data: state.preferences,
                disabled: true
            })
        },

        logout() {
            app.$api.call({
                url: '/logout',
                method: "GET",
            })
        },
    },

    modules: {
        settings: settings,
        permissions: permissions,
        form: FormBase({
            isEditing: true,
            disableLoader: true,
        })
    }
}