import '../../Support/Scss/Custom.scss'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css'

import Vue from "vue";
import Store from './Store'
import Router from './Plugins/router'
import VueFlags from "@growthbunker/vueflags";
import Vuetify from "../../Support/Plugins/Vuetify";

import Api from "../../Support/Providers/Api";
import Auth from "../../Support/Providers/Auth";
import Provider from "../../Support/Plugins/Provider";
import Breadcrumbs from "../../Support/Providers/Breadcrumbs";

Vue.use(Provider, {
    loader: () => {
        const store = Store
        const router = Router
        const app = Vue.prototype
        const vuetify = Vuetify.framework

        app.$api = new Api(app)
        app.$auth = new Auth(store)

        app.$breadcrumbs = Vue.observable(new Breadcrumbs(app, router, vuetify))
    },
    store: Store,
    router: Router
})

Vue.use(VueFlags, {
    iconPath: '/images/flags/',
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
