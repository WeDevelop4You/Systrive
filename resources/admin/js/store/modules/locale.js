import Vue from 'vue';
import Vuetify from "../../plugins/vuetify";

const app = Vue.prototype
const $vuetify = Vuetify.framework

export default {
    namespaced: true,

    state: () => ({
        locale: $vuetify.lang.defaultLocale,
    }),

    mutations: {
        setLocale(state, locale) {
            state.locale = locale;

            $vuetify.lang.current = locale
        }
    },

    getters: {
        locale(state) {
            return state.locale;
        }
    },

    actions: {
        getLocale({commit}) {
            app.$api.call({
                url: app.$api.route('locale'),
                method: "GET"
            }).then((response) => {
                commit('setLocale', response.data.locale)
            })
        },

        setLocale({commit}, locale) {
            app.$api.call({
                url: app.$api.route('locale.change', locale),
                method: "PUT"
            }).then((response) => {
                commit('setLocale', response.data.locale)
            })
        }
    }
}
