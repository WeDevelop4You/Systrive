import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        errors: {}
    }),

    mutations: {
        setError(state, errors) {
            state.errors = errors;
        }
    },

    getters: {
        errors(state) {
            return state.errors
        }
    },

    actions: {
        changePassword({commit}, data) {
            commit('setError', {})

            return app.$api.call({
                url: app.$api.route('user.account.change.password'),
                method: "PATCH",
                data: data
            }).then(() => {
                return true
            }).catch((error) => {
                const errors = error.response.data.errors || {}

                commit('setError', errors)

                return false
            })
        }
    }
}
