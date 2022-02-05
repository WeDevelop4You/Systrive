import Vue from 'vue'
import Vuetify from './vuetify'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

const $vuetify = Vuetify.framework
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
                    text: $vuetify.lang.t('$vuetify.word.dashboard'),
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
        path: '/settings',
        name: 'settings',
        // component: Dashboard,
        meta: {
            breadCrumb: [
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
        path: '/admin',
        component: parent,
        children: [
            {
                path: 'users/:type?/:id?',
                name: 'admin.users',
                component: () => import(/* webpackChunkName: "pages/super_admin/users" */ '../pages/super_admin/Users'),
                meta: {
                    breadCrumb: [
                        {
                            text: $vuetify.lang.t('$vuetify.word.dashboard'),
                            to: {name: 'dashboard'}
                        },
                        {
                            text: $vuetify.lang.t('$vuetify.word.users'),
                        }
                    ],
                }
            },
            {
                path: 'companies/:type?/:id?',
                name: 'admin.companies',
                component: () => import(/* webpackChunkName: "pages/super_admin/companies" */ '../pages/super_admin/company/Index'),
                meta: {
                    breadCrumb: [
                        {
                            text: $vuetify.lang.t('$vuetify.word.dashboard'),
                            to: {name: 'dashboard'}
                        },
                        {
                            text: $vuetify.lang.t('$vuetify.word.companies'),
                        }
                    ]
                }
            },
            {
                path: 'translations/:type?/:id?',
                name: 'admin.translations',
                component: () => import(/* webpackChunkName: "pages/super_admin/translations" */ '../pages/super_admin/Translations'),
                meta: {
                    breadCrumb: [
                        {
                            text: $vuetify.lang.t('$vuetify.word.dashboard'),
                            to: {name: 'dashboard'}
                        },
                        {
                            text: $vuetify.lang.t('$vuetify.word.translations'),
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
                path: 'dashboard',
                name: 'company.dashboard',
                component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../pages/company/Dashboard'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        return [
                            {
                                text: $vuetify.lang.t('$vuetify.word.dashboard'),
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                            }
                        ]
                    }
                },
            },
            {
                path: 'd/:domainName',
                name: 'company.domain',
                component: () => import(/* webpackChunkName: "pages/company/domain/index" */ '../pages/company/domain/Index'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        const domainName = route.params.domainName;
                        return [
                            {
                                text: 'Dashboard',
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                                to: {name: 'company.dashboard', params: {companyName: companyName}}
                            },
                            {
                                text: domainName
                            }
                        ]
                    }
                },
            },
            {
                path: 'dns/:domainNameServer',
                name: 'company.dns',
                component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../pages/company/Dashboard'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        const domainNameServer = route.params.domainNameServer;
                        return [
                            {
                                text: 'Dashboard',
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                                to: {name: 'company.dashboard', params: {companyName: companyName}}
                            },
                            {
                                text: domainNameServer
                            }
                        ]
                    }
                },
            },
            {
                path: 'db/:databaseName',
                name: 'company.database',
                component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../pages/company/Dashboard'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        const databaseName = route.params.databaseName;
                        return [
                            {
                                text: 'Dashboard',
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                                to: {name: 'company.dashboard', params: {companyName: companyName}}
                            },
                            {
                                text: databaseName
                            }
                        ]
                    }
                },
            },
            {
                path: 'm/:mailDomainName',
                name: 'company.mail',
                component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../pages/company/Dashboard'),
                meta: {
                    breadCrumb(route) {
                        const companyName = route.params.companyName;
                        const mailDomainName = route.params.mailDomainName;
                        return [
                            {
                                text: 'Dashboard',
                                to: { name: 'dashboard' }
                            },
                            {
                                text: companyName,
                                to: {name: 'company.dashboard', params: {companyName: companyName}}
                            },
                            {
                                text: mailDomainName
                            }
                        ]
                    }
                },
            },
            {
                path: 'admin',
                component: parent,
                children: [
                    {
                        path: 'users/:type?/:id?',
                        name: 'company.users',
                        component: () => import(/* webpackChunkName: "pages/company/admin/users" */ '../pages/company/admin/Users'),
                        meta: {
                            breadCrumb(route) {
                                const companyName = route.params.companyName;
                                return [
                                    {
                                        text: $vuetify.lang.t('$vuetify.word.dashboard'),
                                        to: { name: 'dashboard' }
                                    },
                                    {
                                        text: companyName,
                                        to: {name: 'company.dashboard', params: {companyName: companyName}}
                                    },
                                    {
                                        text: $vuetify.lang.t('$vuetify.word.users'),
                                    }
                                ]
                            }
                        },
                    },
                    {
                        path: 'roles/:type?/:id?',
                        name: 'company.roles',
                        component: () => import(/* webpackChunkName: "pages/company/admin/roles" */ '../pages/company/admin/Roles'),
                        meta: {
                            breadCrumb(route) {
                                const companyName = route.params.companyName;
                                return [
                                    {
                                        text: $vuetify.lang.t('$vuetify.word.dashboard'),
                                        to: { name: 'dashboard' }
                                    },
                                    {
                                        text: companyName,
                                        to: {name: 'company.dashboard', params: {companyName: companyName}}
                                    },
                                    {
                                        text: $vuetify.lang.t('$vuetify.word.roles'),
                                    }
                                ]
                            }
                        },
                    }
                ]
            },
        ]
    },
    {
        path: '*',
        component: () => import(/* webpackChunkName: "pages/dashboard" */ '../pages/Dashboard'),
    }
]

export default new VueRouter({
    mode: 'history',
    routes: routes
})
