import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Dashboard from "../pages/Dashboard";
import CompanyDashboard from "../pages/company/Dashboard";

const routes = [
    {
        path: '/',
        alias: '/dashboard',
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
        // component: Dashboard,
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
        path: '/:companyName',
        name: 'company.dashboard',
        component: CompanyDashboard,
        meta: {
            breadCrumb(route) {
                const companyName = route.params.company;
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
        children: [
            {
                path: 'test',
                name: 'company.test'
            }
        ]
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
