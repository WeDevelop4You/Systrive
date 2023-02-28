import Vue from 'vue';

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        items: {},
    }),

    mutations: {
        setItems(state, data) {
            state.items = data
        }
    },

    getters: {
        items(state) {
            return state.items
        }
    },

    actions: {
        getItems({commit}) {
            app.$api.call({
                url: app.$api.route('misc.locales'),
                method: "GET"
            }).then((response) => {
                commit('setItems', response.data.data)
            })
        },

        change({commit}, locale) {
            commit('locale/set', locale, {root: true})

            return app.$api.call({
                url: app.$api.route('account.locale.change', locale.identifier),
                method: "PUT",
                silence: true
            })
        }
    }
}
