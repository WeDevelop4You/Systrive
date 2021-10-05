import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Dashboard from "../pages/Dashboard";
import CompanyDashboard from "../pages/company/dashboard";

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
        path: '/:company',
        name: 'company',
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
        }
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
