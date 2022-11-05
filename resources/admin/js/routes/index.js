import Import from "../helpers/Import";
import Breadcrumb from "../helpers/Breadcrumb";

// routes
import Company from "./company"
import SuperAdmin from "./super_admin"

const app = Import.app()
const $vuetify = Import.vuetify()
const $parent = {template: `<router-view></router-view>`}

export default [
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
        component: () => import('../views/Dashboard.vue'),
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs() {
                app.$breadcrumbs.setDashboard()
            }
        }
    },
    {
        path: '/account',
        name: 'account',
        component: () => import('../views/Account/Profile.vue'),
        meta: {
            isAuthenticatedPage: true,
            breadcrumbs() {
                app.$breadcrumbs.setDashboard(true)
                    .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.account.account')))
            }
        }
    },
    {
        path: '/s',
        component: $parent,
        children: [
            {
                path: ':page(personal|security|git)',
                name: 'account.settings',
                component: () => import('../views/Account/Settings.vue'),
                meta: {
                    isAuthenticatedPage: true,
                    breadcrumbs() {
                        app.$breadcrumbs.setDashboard(true)
                            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.settings')))
                    }
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
