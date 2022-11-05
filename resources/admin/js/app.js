import './bootstrap'
import '../sass/custom.scss'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css'

import Vue from 'vue'
import Store from './store'
import Router from './plugins/routes'
import Vuetify from './plugins/vuetify'
import Provider from './plugins/provider'
import VueFlags from "@growthbunker/vueflags"

Vue.config.productionTip = false

Vue.use(Provider)
Vue.use(VueFlags, {
    iconPath: '/images/flags/',
})

export default new Vue({
    store: Store,
    vuetify: Vuetify,
    router: Router,

    components: {
        LApp: () => import('./layout/Base/App.vue'),
        Login: () => import('./views/Auth/Login.vue'),
        Registration: () => import('./views/Auth/Registration.vue'),
        ResetPassword: () => import('./views/Auth/ResetPassword.vue'),
        PasswordRecovery: () => import('./views/Auth/PasswordRecovery.vue')
    }
}).$mount('#mount');
