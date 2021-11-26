import './bootstrap'

import Vue from 'vue'
import Store from './store'
import Api from './plugins/api'
import LApp from './layout/App'
import Auth from './plugins/auth'
import Router from './plugins/routes'
import Config from './plugins/config'
import Action from './plugins/actions'
import Login from './pages/auth/Login'
import Vuetify from './plugins/vuetify'
import ResetPassword from './pages/auth/ResetPassword'
import PasswordRecovery from './pages/auth/PasswordRecovery'

Vue.config.productionTip = false

Vue.use(Api)
Vue.use(Auth)
Vue.use(Config)
Vue.use(Action)

Vue.component('LApp', LApp)
Vue.component('Login', Login)
Vue.component('ResetPassword', ResetPassword)
Vue.component('PasswordRecovery', PasswordRecovery)

export default new Vue({
    el: '#app',
    store: Store,
    vuetify: Vuetify,
    router: Router,

    data() {
        return {
            requests: 0,
            lastRoute: '/'
        }
    },

    created() {
        let app = this

        this.$api.call.interceptors.request.use(function (config) {
            app.requests++

            return config
        }, function (error) {
            app.requests--

            return Promise.reject(error)
        });

        this.$api.call.interceptors.response.use(function (response) {
            app.requests--

            app.responseActions(response.data)

            return response
        }, function (error) {
            app.requests--

            app.responseActions(error.response.data)

            return Promise.reject(error)
        });
    },

    methods: {
        responseActions(data) {
            this.addPopup(data)
            this.callAction(data)
        },

        addPopup(data) {
            if (Object.prototype.hasOwnProperty.call(data,'popup')) {
                this.$store.dispatch('notifications/popup', data.popup);
            }
        }
    }
});
