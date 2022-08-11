import Helper from "../Providers/Helper";

// routes
import Company from "./company"
import SuperAdmin from "./super_admin"

const $vuetify = Helper.getVuetify()
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
        component: () => import('../pages/Dashboard.vue'),
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
        component: () => import('../pages/Account/Profile.vue'),
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
                component: () => import('../pages/Account/Settings.vue'),
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
