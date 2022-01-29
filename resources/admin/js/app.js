import './bootstrap'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css';

import Vue from 'vue'
import Store from './store'
import Api from './plugins/api'
import Auth from './plugins/auth'
import Router from './plugins/routes'
import Config from './plugins/config'
import Action from './plugins/actions'
import Vuetify from './plugins/vuetify'
import VueFlags from "@growthbunker/vueflags"

Vue.config.productionTip = false

Vue.use(Api)
Vue.use(Auth)
Vue.use(Config)
Vue.use(Action)
Vue.use(VueFlags, {
    iconPath: '/images/flags/',
})

Vue.component('LApp', () => import(/* webpackChunkName: "layout/app" */ './layout/App'))
Vue.component('Login', () => import(/* webpackChunkName: "pages/auth/login" */ './pages/auth/Login'))
Vue.component('Registration', () => import(/* webpackChunkName: "pages/auth/registration" */ './pages/auth/Registration'))
Vue.component('ResetPassword', () => import(/* webpackChunkName: "pages/auth/reset_password" */ './pages/auth/ResetPassword'))
Vue.component('PasswordRecovery', () => import(/* webpackChunkName: "pages/auth/password_recovery" */ './pages/auth/PasswordRecovery'))

export default new Vue({
    el: '#app',
    store: Store,
    vuetify: Vuetify,
    router: Router,

    data() {
        return {
            requests: 0,
            lastRoute: {
                name: 'dashboard'
            }
        }
    },

    async created() {
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

        await this.load()
    },

    methods: {
        responseActions(data) {
            this.redirect(data)
            this.addPopup(data)
            this.callAction(data)
        },

        addPopup(data) {
            if (Object.prototype.hasOwnProperty.call(data,'popup')) {
                this.$store.dispatch('popups/addPopup', data.popup);
            }
        },

        redirect(data) {
            if (Object.prototype.hasOwnProperty.call(data,'redirect')) {
                window.location.href = data.redirect
            }
        },

        async load() {
            await this.$store.dispatch('locale/getOne')
            await this.$store.dispatch('locale/getMany')
        }
    }
});
