import Vue from 'vue';
import Vuetify from "../../Plugins/Vuetify";

const app = Vue.prototype
const $vuetify = Vuetify.framework

export default {
    namespaced: true,

    state: () => ({
        name: '',
        identifier: $vuetify.lang.defaultLocale,
    }),

    mutations: {
        set(state, data) {
            state.name = data.name;
            state.identifier = data.identifier

            $vuetify.lang.current = data.identifier;
        },
    },

    getters: {
        data(state) {
            return state;
        },
    },

    actions: {
        get({commit}) {
            app.$api.call({
                url: app.$api.route('account.locale'),
                method: "GET"
            }).then((response) => {
                commit('set', response.data.data)
            })
        },
    }
}
