import Vue from 'vue';
import Vuetify from "../../Plugins/Vuetify";

const app = Vue.prototype
const $vuetify = Vuetify.framework

export default {
    state: () => ({
        locale: $vuetify.lang.defaultLocale,
    }),

    mutations: {
        setLocale(state, locale) {
            state.locale = locale;

            $vuetify.lang.current = locale
        },
    },

    getters: {
        locale(state) {
            return state.locale;
        },
    },

    actions: {
        getLocale({commit}) {
            app.$api.call({
                url: app.$api.route('account.locale'),
                method: "GET"
            }).then((response) => {
                commit('setLocale', response.data.data.locale)
            })
        },
    }
}
