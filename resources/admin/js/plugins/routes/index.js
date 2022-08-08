import Vue from 'vue'
import Helper from "../../Providers/Helper";
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// routes
import Company from "./company"
import SuperAdmin from "./super_admin"

const app = Helper.getApp(Vue)
const $store = Helper.getStore()
const $vuetify = Helper.getVuetify()
const $parent = {template: `<router-view></router-view>`}

const routes = [
    {
        path: '/login'
    },
    {
        path: '/password/recovery'
    },
    {
        path: '/reset/password/:token/:encryptEmail'
    },
    {
        path: '/registration'
    },
    {
        path: '/dashboard',
        alias: '/',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "pages/dashboard" */ '../../pages/Dashboard'),
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                }
            ]
        }
    },
    {
        path: '/account',
        name: 'account',
        component: () => import(/* webpackChunkName: "pages/account" */ '../../pages/Account/Profile'),
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: $vuetify.lang.t('$vuetify.word.account.account'),
                }
            ]
        }
    },
    {
        path: '/s',
        component: $parent,
        children: [
            {
                path: ':page(personal|security|git)',
                name: 'account.settings',
                component: () => import(/* webpackChunkName: "pages/account/settings" */ '../../pages/Account/Settings'),
                meta: {
                    isAuthenticatedPage: true,
                    breadcrumbs: [
                        {
                            text: $vuetify.lang.t('$vuetify.word.dashboard'),
                            to: { name: 'dashboard' }
                        },
                        {
                            text: $vuetify.lang.t('$vuetify.word.settings'),
                        }
                    ]
                }
            },
            {
                path: '*',
                redirect: {name: 'account.settings', params: {page: 'personal'}},
            }
        ]
    },
    {
        path: '/sa',
        component: $parent,
        redirect: {name: 'dashboard'},
        children: SuperAdmin
    },
    {
        path: '/c/:companyName',
        component: $parent,
        redirect: {name: 'dashboard'},
        children: Company
    },
    {
        path: '*',
        redirect: {name: 'dashboard'},
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach(async (to, from, next) => {
    app.$activity.lastRoute = from.name ? from : to

    if (to.meta.isAuthenticatedPage) {
        const page = to.meta.page

        if (!app.$auth.check()) {
            app.$auth.load();
        }

        if ((!page && !from.name) || page !== from.meta.page) {
            switch (page) {
                case 'company':
                    await $store.dispatch('company/search', to.params.companyName)
                    await $store.dispatch('user/auth/permissions/getCompany')
                    break
                default:
                    await $store.dispatch('navigation/main')
                    await $store.dispatch('user/auth/permissions/getDefault')
                    break
            }
        }
    }

    next()
})

export default router
