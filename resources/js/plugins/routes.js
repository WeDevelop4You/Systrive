import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Login from '../pages/auth/Login'

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
    }
]

export default new VueRouter({
    history: true,
    mode: 'history',
    routes: routes
})
