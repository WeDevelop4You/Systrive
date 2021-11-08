import Vue from 'vue'
import Vuetify from "../../plugins/vuetify"


const app = Vue.prototype
const vuetify = Vuetify.framework

export default {
    namespaced: true,

    state: () => ({
        menuItems: [],
        companies: [],
    }),

    mutations: {
        setMainMenuItems(state) {
            state.menuItems = [
                {subheader: vuetify.lang.t('$vuetify.word.companies')},
                {navigationItems: state.companies},
                {divider: true},
                {subheader: vuetify.lang.t('$vuetify.word.admin')},
                {navigationItems: [
                        {icon: 'fas fa-users', name: vuetify.lang.t('$vuetify.word.users'), route: {name: 'admin.users'}},
                        {icon: 'fas fa-building', name: vuetify.lang.t('$vuetify.word.companies'), route: {name: 'admin.companies'}},
                        {icon: 'fas fa-language', name: vuetify.lang.t('$vuetify.word.translations'), route: {name: 'admin.translations'}},
                    ]
                },
            ]
        },

        setCompanyMenuItems(state) {
            state.menuItems = [
                {subheader: vuetify.lang.t('$vuetify.word.domains')},
                {navigationItems: []},
                {divider: true},
                {navigationItems: [

                    ]
                },
            ]
        },

        setCompany(state, data) {
            state.companies = data
        }
    },

    getters: {
        menuItems(state) {
            return state.menuItems
        }
    },

    actions: {
        getCompanies({commit}, setMenuItems = false) {
            app.$api.call({
                url: app.$api.route('user.companies'),
                method: "GET"
            }).then((response) => {
                commit('setCompany', response.data.data)

                if (setMenuItems) {
                    commit("setMainMenuItems")
                }
            })
        },
    },
}
