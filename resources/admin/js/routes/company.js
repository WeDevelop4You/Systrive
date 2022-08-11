import Helper from "../Providers/Helper";
import {STATE_EDIT, STATE_NEW} from "../Providers/Config";

const $vuetify = Helper.getVuetify()
const parent = {template: `<router-view></router-view>`}

export default [
    {
        path: 'dashboard',
        name: 'company.dashboard',
        component: () => import('../pages/Company/Dashboard.vue'),
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
        component: () => import('../pages/Company/System/Domain.vue'),
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
        component: () => import('../pages/Company/System/DomainNameServer.vue'),
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
        component: () => import('../pages/Company/System/Database.vue'),
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
        component: () => import('../pages/Company/System/MailDomain.vue'),
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
                component: () => import('../pages/Company/Admin/Users.vue'),
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
                component: () => import('../pages/Company/Admin/Roles.vue'),
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
