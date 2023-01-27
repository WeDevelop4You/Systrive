import '../../Support/Scss/Custom.scss'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css'

import Vue from "vue";
import Store from "./Store";
import Router from "./Plugins/router";
import Vuetify from "../../Support/Plugins/Vuetify";

import Api from "./Providers/Api";
import Auth from "../../Support/Providers/Auth";
import State from "../../Support/Providers/State";
import Breadcrumbs from "./Providers/Breadcrumbs";
import Loader from "../../Support/Providers/Loader";
import Provider from "../../Support/Plugins/Provider";

Vue.use(Provider, {
    store: Store,
    router: Router,
    vuetify: Vuetify.framework,
    loader: ({app, store, router, vuetify}) => {
        // First load Api
        app.$api = new Api(app, store)

        app.$state = new State(router)
        app.$auth = new Auth(store, vuetify)
        app.$loader = new Loader(app, store, router)
        app.$breadcrumbs = new Breadcrumbs(app, store, router, vuetify)
    }
})

Vue.config.productionTip = false

export default new Vue({
    name: 'Company',

    store: Store,
    router: Router,
    vuetify: Vuetify,

    components: {
        CompanyLayout: () => import('./Layout/CompanyLayout.vue'),
    }
}).$mount('#mount')
