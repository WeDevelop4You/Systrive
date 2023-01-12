import '../../Support/Scss/Custom.scss'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css'

import Vue from "vue";
import Store from "./Store";
import Router from "./Plugins/router";
import Vuetify from "../../Support/Plugins/Vuetify";

import Api from "./Providers/Api";
import Auth from "../../Support/Providers/Auth";
import State from "../../Support/Providers/State";
import Loader from "../../Support/Providers/Loader";
import Provider from "../../Support/Plugins/Provider";
import WebSocket from "../../Support/Providers/WebSocket";
import Breadcrumbs from "../../Support/Providers/Breadcrumbs";

Vue.use(Provider, {
    loader: () => {
        const store = Store
        const router = Router
        const app = Vue.prototype
        const vuetify = Vuetify.framework

        // First load Api
        app.$api = new Api(app, store)

        app.$auth = new Auth(store)
        app.$state = new State(router)
        app.$loader = new Loader(app, store, router, vuetify)

        app.$breadcrumbs = Vue.observable(new Breadcrumbs(app, router, vuetify))

        new WebSocket(app)
    },
    store: Store,
    router: Router
})

Vue.config.productionTip = false

export default new Vue({
    name: 'Admin',

    store: Store,
    router: Router,
    vuetify: Vuetify,

    components: {
        AdminLayout: () => import('./Layout/AdminLayout.vue'),
    }
}).$mount('#mount')
