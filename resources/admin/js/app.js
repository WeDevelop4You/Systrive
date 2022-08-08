import './bootstrap'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css';

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
        LApp: () => import(/* webpackChunkName: "layout/app" */ './layout/Base/App'),
        Login: () => import(/* webpackChunkName: "pages/auth/login" */ './pages/Auth/Login'),
        Registration: () => import(/* webpackChunkName: "pages/auth/registration" */ './pages/Auth/Registration'),
        ResetPassword: () => import(/* webpackChunkName: "pages/auth/reset_password" */ './pages/Auth/ResetPassword'),
        PasswordRecovery: () => import(/* webpackChunkName: "pages/auth/password_recovery" */ './pages/Auth/PasswordRecovery')
    }
}).$mount('#mount');
