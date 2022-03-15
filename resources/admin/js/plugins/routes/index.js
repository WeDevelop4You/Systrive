import Vue from 'vue'
import $store from '../../store'
import Vuetify from '../vuetify'
import VueRouter from 'vue-router';

// routes
import Company from "./company";
import Settings from "./settings";
import SuperAdmin from "./super_admin";

Vue.use(VueRouter)

const $vuetify = Vuetify.framework
const parent = {template: `<router-view></router-view>`}

const routes = [
    {
        path: '/dashboard',
        alias: '/',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "pages/dashboard" */ '../../pages/Dashboard'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
                {
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
                }
            ]
        }
    },
    {
        path: '/account',
        name: 'account',
        component: () => import(/* webpackChunkName: "pages/account" */ '../../pages/account/Profile'),
        meta: {
            isAuthenticatedPage: true,
            breadCrumb: [
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
        component: () => import(/* webpackChunkName: "pages/account/settings" */ '../../layout/base/settings/Account'),
        redirect: {name: 'user.setting.personal'},
        children: Settings,
    },
    {
        path: '/sa',
        component: parent,
        redirect: {name: 'dashboard'},
        children: SuperAdmin
    },
    {
        path: '/c/:companyName',
        component: parent,
        redirect: {name: 'dashboard'},
        children: Company
    },
    {
        path: '*',
        component: () => import(/* webpackChunkName: "pages/dashboard" */ '../../pages/Dashboard'),
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach(async (to, from, next) => {
    if (to.meta.isAuthenticatedPage) {
        const page = to.meta.page

        if (!page || page !== from.meta.page) {
            switch (page) {
                case 'company':
                    await $store.dispatch('company/search', to.params.companyName)
                    await $store.dispatch('user/permissions/getCompany')
                    break
                default:
                    await $store.dispatch('navigation/getCompanies')
                    await $store.dispatch('user/permissions/getDefault')
                    break
            }
        }
    }

    next()
})

export default router
