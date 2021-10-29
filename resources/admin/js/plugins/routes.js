import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

const parent = {template: `<router-view></router-view>`}

const routes = [
    {
        path: '/dashboard',
        alias: '/',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "pages/dashboard" */ '../pages/Dashboard'),
        meta: {
            breadCrumb: [
                {
                    text: 'Dashboard'
                }
            ]
        }
    },
    {
        path: '/account',
        name: 'account',
        component: () => import(/* webpackChunkName: "pages/account" */ '../pages/account/Profile'),
        meta: {
            breadCrumb: [
                {
                    text: 'Dashboard',
                    to: { name: 'dashboard' }
                },
                {
                    text: 'Account'
                }
            ]
        }
    },
    {
        path: '/settings',
        name: 'settings',
        // component: Dashboard,
        meta: {
            breadCrumb: [
                {
                    text: 'Dashboard',
                    to: { name: 'dashboard' }
                },
                {
                    text: 'Settings'
                }
            ]
        }
    },
    {
        path: '/admin',
        component: parent,
        children: [
            {
                path: 'accounts',
                name: 'admin.accounts',
                component: () => import(/* webpackChunkName: "pages/admin/accounts" */ '../pages/admin/Accounts'),
                meta: {
                    breadCrumb: [
                        {
                            text: 'Dashboard',
                            to: {name: 'dashboard'}
                        },
                        {
                            text: 'Accounts'
                        }
                    ]
                }
            },
            {
                path: 'companies',
                name: 'admin.companies',
                component: () => import(/* webpackChunkName: "pages/admin/companies" */ '../pages/admin/company'),
                meta: {
                    breadCrumb: [
                        {
                            text: 'Dashboard',
                            to: {name: 'dashboard'}
                        },
                        {
                            text: 'Companies'
                        }
                    ]
                }
            },
            {
                path: 'translations',
                name: 'admin.translations',
                component: () => import(/* webpackChunkName: "pages/admin/translations" */ '../pages/admin/Translations'),
                meta: {
                    breadCrumb: [
                        {
                            text: 'Dashboard',
                            to: {name: 'dashboard'}
                        },
                        {
                            text: 'Translations'
                        }
                    ]
                }
            },
        ]
    },
    {
        path: '/c/:companyName',
        component: () => import(/* webpackChunkName: "pages/company" */ '../layout/Company'),
        children: [
            {
                path: '',
                name: 'company.dashboard',
                component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../pages/company/Dashboard'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        return [
                            {
                                text: 'Dashboard',
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                            }

                        ]
                    }
                },
            }
        ]
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
