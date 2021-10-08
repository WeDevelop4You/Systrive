import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

const parent = {template: `<router-view></router-view>`}

import Dashboard from "../pages/Dashboard";
import AdminUsers from "../pages/admin/Users";
import Profile from "../pages/account/Profile";
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
                path: 'users',
                name: 'admin.users',
                component: AdminUsers,
                meta: {
                    breadCrumb: [
                        {
                            text: 'Dashboard',
                            to: {name: 'dashboard'}
                        },
                        {
                            text: 'Users'
                        }
                    ]
                }
            },
            {
                path: 'companies',
                name: 'admin.companies',
                // component: '',
            }
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
