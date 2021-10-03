import './bootstrap'

import Vue from 'vue'
import Store from './store'
import Api from './plugins/api'
import LApp from './layout/App'
import Auth from './plugins/auth'
import Router from './plugins/routes'
import Config from './plugins/config'
import Login from './pages/auth/Login'
import Loading from './plugins/loading'
import Vuetify from './plugins/vuetify'
import ResetPassword from './pages/auth/ResetPassword'
import PasswordRecovery from './pages/auth/PasswordRecovery'

Vue.config.productionTip = false

Vue.use(Api)
Vue.use(Auth)
Vue.use(Config)
Vue.use(Loading)

Vue.component('l-app', LApp)
Vue.component('login', Login)
Vue.component('reset-password', ResetPassword)
Vue.component('password-recovery', PasswordRecovery)

export default new Vue({
    el: '#app',
    store: Store,
    vuetify: Vuetify,
    router: Router,
});
