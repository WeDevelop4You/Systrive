import Vue from 'vue';
import tableBase from "./tableBase";

const app = Vue.prototype

export default {
    namespaced: true,

    state: () => ({
        environments: [],
        selected: {}
    }),

    mutations: {
        setEnvironments(state, environments) {
            state.environments = environments
        },

        setSelected(stata, translation) {
            stata.selected = translation
        }
    },

    getters: {
        environments(state) {
            return state.environments
        },

        selected(state) {
            return state.selected
        }
    },

    actions: {
        getEnvironments({commit}) {
            app.$api.call({
                url: app.$api.route('admin.translations.environments'),
                method: 'GET',
            }).then((response) => {
                commit('setEnvironments', response.data.data)
            })
        },

        getTranslation({commit}, id) {
            app.$api.call({
                url: app.$api.route('admin.translation', id),
                method: "GET"
            }).then((response) => {
                commit('setSelected', response.data.data)
                commit('changeEditDialog', true)
            })
        }
    },

    modules: {
        tableBase: tableBase
    }
}
