import Vuetify from "../vuetify";
import {STATE_EDIT, STATE_NEW} from "../config";

const $vuetify = Vuetify.framework
const parent = {template: `<router-view></router-view>`}

export default [
    {
        path: 'dashboard',
        name: 'company.dashboard',
        component: () => import(/* webpackChunkName: "pages/company/dashboard" */ '../../pages/Company/Dashboard'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
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
        path: 'd/:domainName/:chapters*',
        name: 'company.domain',
        component: () => import(/* webpackChunkName: "pages/company/system/domain" */ '../../pages/Company/System/Domain'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
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
        component: () => import(/* webpackChunkName: "pages/company/system/dns" */ '../../pages/Company/System/DomainNameServer'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
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
        component: () => import(/* webpackChunkName: "pages/company/system/database" */ '../../pages/Company/System/Database'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
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
        component: () => import(/* webpackChunkName: "pages/company/system/mail_domain" */ '../../pages/Company/System/MailDomain'),
        meta: {
            page: 'company',
            isAuthenticatedPage: true,
            breadcrumbs(route) {
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
                path: 'users/:chapters*',
                name: 'company.users',
                component: () => import(/* webpackChunkName: "pages/company/admin/users" */ '../../pages/Company/Admin/Users'),
                meta: {
                    page: 'company',
                    isAuthenticatedPage: true,
                    allowedStates: [STATE_NEW, STATE_EDIT],
                    breadcrumbs(route) {
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
                path: 'roles/:chapters*',
                name: 'company.roles',
                component: () => import(/* webpackChunkName: "pages/company/admin/roles" */ '../../pages/Company/Admin/Roles'),
                meta: {
                    page: 'company',
                    isAuthenticatedPage: true,
                    allowedStates: [STATE_NEW, STATE_EDIT],
                    breadcrumbs(route) {
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
