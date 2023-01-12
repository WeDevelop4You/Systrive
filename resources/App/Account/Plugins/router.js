import Vue from "vue";
import Routes from "../Routes";
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: Routes
})

export default router
