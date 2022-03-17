import Vuetify from "../vuetify";

const $vuetify = Vuetify.framework
const parent = {template: `<router-view></router-view>`}

export default [
    {
        path: 'dashboard',
        name: 'company.dashboard',
        component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../../pages/company/Dashboard'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
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
        component: () => import(/* webpackChunkName: "pages/company/domain/index" */ '../../pages/company/domain/Index'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
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
                        text: $vuetify.lang.t('$vuetify.word.domain.domain')
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
        component: () => import(/* webpackChunkName: "pages/company/dns/index" */ '../../pages/company/dns/Index'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
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
                        text: $vuetify.lang.t('$vuetify.word.dns.dns')
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
        component: () => import(/* webpackChunkName: "pages/company/database/index" */ '../../pages/company/database/Index'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
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
                        text: $vuetify.lang.t('$vuetify.word.database.database')
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
        component: () => import(/* webpackChunkName: "pages/company/mail_domain" */ '../../pages/company/mail_domain/Index'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
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
                        text: $vuetify.lang.t('$vuetify.word.mail.domain'),
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
                component: () => import(/* webpackChunkName: "pages/company/admin/users" */ '../../pages/company/admin/Users'),
                meta: {
                    page: 'company',
                    isAuthenticatedPage: true,
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
                                text: $vuetify.lang.t('$vuetify.word.admin'),
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
                component: () => import(/* webpackChunkName: "pages/company/admin/roles" */ '../../pages/company/admin/Roles'),
                meta: {
                    page: 'company',
                    isAuthenticatedPage: true,
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
                                text: $vuetify.lang.t('$vuetify.word.admin'),
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
