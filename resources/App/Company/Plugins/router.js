import Vue from "vue";
import VueRouter from "vue-router";
import Routes from "../Routes";

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: Routes
})

export default router
