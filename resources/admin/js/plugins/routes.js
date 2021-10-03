import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Dashboard from "../pages/Dashboard";

const routes = [
    {
        path: '/',
        alias: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
