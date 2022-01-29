import Vue from 'vue'
import Vuetify from "../../plugins/vuetify"
import Permissions from "../../config/permissions"

const app = Vue.prototype
const $vuetify = Vuetify.framework
const $permissions = Permissions

export default {
    namespaced: true,

    state: () => ({
        menuItems: [],
    }),

    mutations: {
        setMainMenuItems(state, companies) {
            state.menuItems = [
                {subheader: $vuetify.lang.t('$vuetify.word.companies')},
                {navigationItems: companies},
                {can: $permissions.superAdmin, divider: true},
                {can: $permissions.superAdmin, subheader: $vuetify.lang.t('$vuetify.word.admin')},
                {
                    can: $permissions.superAdmin,
                    navigationItems: [
                        {icon: 'fas fa-users', name: $vuetify.lang.t('$vuetify.word.users'), route: {name: 'admin.users'}},
                        {icon: 'fas fa-address-card', name: $vuetify.lang.t('$vuetify.word.companies'), route: {name: 'admin.companies'}},
                        {icon: 'fas fa-language', name: $vuetify.lang.t('$vuetify.word.translations'), route: {name: 'admin.translations'}},
                    ]
                },
            ]
        },

        setCompanyMenuItems(state, company) {
            const companyAdmin = app.$config.permissions.companyAdmin

            state.menuItems = [
                {
                    navigationItems: [
                        {
                            icon: 'fas fa-home',
                            name: $vuetify.lang.t('$vuetify.word.dashboard'),
                            route: {name: 'company.dashboard', params: {companyName: company.name}}},
                    ]
                },
                {
                    type: 'expand',
                    icon: 'fas fa-globe',
                    title: $vuetify.lang.t('$vuetify.word.domains'),
                    navigationItems: company.domains
                },
                {
                    type: 'expand',
                    icon: 'fas fa-sitemap',
                    title: $vuetify.lang.t('$vuetify.word.dns'),
                    navigationItems: company.dns
                },
                {
                    type: 'expand',
                    icon: 'fas fa-server',
                    title: $vuetify.lang.t('$vuetify.word.databases'),
                    navigationItems: company.databases
                },
                {
                    type: 'expand',
                    icon: 'fas fa-mail-bulk',
                    title: $vuetify.lang.t('$vuetify.word.mail.domains'),
                    navigationItems: company.mail_domains
                },
                {divider: true},
                {can: companyAdmin, subheader: $vuetify.lang.t('$vuetify.word.admin')},
                {
                    can: companyAdmin,
                    navigationItems: [
                        {
                            can: $permissions.user.view,
                            icon: 'fas fa-users-cog',
                            name: $vuetify.lang.t('$vuetify.word.users'),
                            route: {name: 'company.users'}
                        },
                        {
                            can: $permissions.role.view,
                            icon: 'fas fa-user-shield',
                            name: $vuetify.lang.t('$vuetify.word.roles'),
                            route: {name: 'company.roles'}
                        },
                    ]
                },
            ]
        },
    },

    getters: {
        menuItems(state) {
            return state.menuItems
        }
    },

    actions: {
        getCompanies({commit}) {
            app.$api.call({
                url: app.$api.route('auth.navigation'),
                method: "GET"
            }).then((response) => {
                commit("setMainMenuItems", response.data.data)
            })
        },

        getCompanyMenuItems({commit}, id) {
            app.$api.call({
                url: app.$api.route('company.navigation', id),
                method: "GET"
            }).then((response) => {
                commit("setCompanyMenuItems", response.data.data)
            })
        },
    },
}
