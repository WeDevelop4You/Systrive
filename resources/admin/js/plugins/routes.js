import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

const parent = {template: `<router-view></router-view>`}

import Dashboard from "../pages/Dashboard";
import Profile from "../pages/account/Profile";
import AdminAccounts from "../pages/admin/Accounts";
import AdminCompanies from "../pages/admin/Companies";
import AdminTranslations from "../pages/admin/Translations";
import CompanyDashboard from "../pages/company/Dashboard";

const routes = [
    {
        path: '/dashboard',
        alias: '/',
        name: 'dashboard',
        component: Dashboard,
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
        component: Profile,
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
                component: AdminAccounts,
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
                component: AdminCompanies,
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
                component: AdminTranslations,
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
        component: parent,
        children: [
            {
                path: '',
                name: 'company.dashboard',
                component: CompanyDashboard,
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
            },
            {
                path: 'test',
                name: 'company.test',
                component: Profile
            }
        ]
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
