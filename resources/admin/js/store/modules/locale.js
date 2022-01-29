import Vue from 'vue';
import Vuetify from "../../plugins/vuetify";

const app = Vue.prototype
const $vuetify = Vuetify.framework

export default {
    namespaced: true,

    state: () => ({
        items: {},
        locale: $vuetify.lang.defaultLocale,
    }),

    mutations: {
        setLocale(state, locale) {
            state.locale = locale;

            $vuetify.lang.current = locale
        },

        setItems(state, data) {
            state.items = data
        }
    },

    getters: {
        locale(state) {
            return state.locale;
        },

        items(state) {
            return state.items
        }
    },

    actions: {
        getOne({commit}) {
            app.$api.call({
                url: app.$api.route('locale'),
                method: "GET"
            }).then((response) => {
                commit('setLocale', response.data.data.locale)
            })
        },

        getMany({commit}) {
            app.$api.call({
                url: app.$api.route('locales'),
                method: "GET"
            }).then((response) => {
                commit('setItems', response.data.data)
            })
        },

        setLocale({commit}, locale) {
            app.$api.getCsrfToken().then(() => {
                app.$api.call({
                    url: app.$api.route('locale.change', locale),
                    method: "PUT"
                }).then((response) => {
                    commit('setLocale', response.data.data.locale)
                })
            })
        }
    }
}
