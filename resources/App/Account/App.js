import '../../Support/Scss/Custom.scss'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css'

import Vue from "vue";
import Store from './Store'
import Router from './Plugins/router'
import Vuetify from "../../Support/Plugins/Vuetify";

import Api from "../../Support/Providers/Api";
import Auth from "../../Support/Providers/Auth";
import Provider from "../../Support/Plugins/Provider";
import Breadcrumbs from "../../Support/Providers/Breadcrumbs";

Vue.use(Provider, {
    store: Store,
    router: Router,
    vuetify: Vuetify.framework,
    loader: ({app, store, router, vuetify}) => {
        app.$api = new Api(app)
        app.$auth = new Auth(store, vuetify)
        app.$breadcrumbs = new Breadcrumbs(app, store, router, vuetify)
    }
})

Vue.config.productionTip = false

export default new Vue({
    name: 'Account',

    store: Store,
    router: Router,
    vuetify: Vuetify,

    components: {
        AuthLayout: () => import('./Layout/AuthLayout.vue'),
        SettingsLayout: () => import('./Layout/SettingsLayout.vue'),
    },

    mounted() {
        this.$store.dispatch('locales/getItems')
    }
}).$mount('#mount');
