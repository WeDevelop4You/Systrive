import Vue from 'vue';

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
    },

    getters: {
        data(state) {
            return state.data
        },

        preferences(state) {
            return state.preferences
        },
    },

    actions: {
        getUser({commit}) {
            return app.$api.call({
                url: app.$api.route('account.user'),
                method: "GET"
            }).then((response) => {
                const data = response.data.data

                commit('setData', data)

                return true
            }).catch(() => false);
        },

        getPreferences({commit}) {
            return app.$api.call({
                url: app.$api.route('account.preferences'),
                method: "GET"
            }).then((response) => {
                const data = response.data.data || {}

                for (const [key, value] of Object.entries(data)) {
                    commit('setPreference', {type: key, value})
                }

                return true
            }).catch(() => false)
        },

        updatePreferences({state}) {
            app.$api.call({
                url: app.$api.route('account.preferences'),
                method: "PATCH",
                data: state.preferences,
                silence: true
            })
        },

        logout() {
            app.$api.call({
                url: '/logout',
                method: "GET",
            })
        },
    },
}
