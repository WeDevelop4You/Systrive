import './bootstrap'
import 'line-awesome/dist/font-awesome-line-awesome/css/all.min.css';

import Vue from 'vue'
import _ from "lodash"
import Store from './store'
import Api from './plugins/api'
import Auth from './plugins/auth'
import Router from './plugins/routes'
import Config from './plugins/config'
import Action from './plugins/actions'
import Vuetify from './plugins/vuetify'
import RouteLoader from './plugins/route'
import VueFlags from "@growthbunker/vueflags"

Vue.config.productionTip = false

Vue.use(Api)
Vue.use(Auth)
Vue.use(Config)
Vue.use(Action)
Vue.use(RouteLoader)
Vue.use(VueFlags, {
    iconPath: '/images/flags/',
})

Vue.component('LApp', () => import(/* webpackChunkName: "layout/app" */ './layout/Base/App'))
Vue.component('Login', () => import(/* webpackChunkName: "pages/auth/login" */ './pages/Auth/Login'))
Vue.component('Registration', () => import(/* webpackChunkName: "pages/auth/registration" */ './pages/Auth/Registration'))
Vue.component('ResetPassword', () => import(/* webpackChunkName: "pages/auth/reset_password" */ './pages/Auth/ResetPassword'))
Vue.component('PasswordRecovery', () => import(/* webpackChunkName: "pages/auth/password_recovery" */ './pages/Auth/PasswordRecovery'))

export default new Vue({
    el: '#app',

    store: Store,
    vuetify: Vuetify,
    router: Router,

    async created() {
        this.createResponseChain()
        this.createInterceptors()
        this.createPreferenceActions()
    },

    methods: {
        createResponseChain() {
            Vue.prototype.$responseChain = function(data) {
                if (Object.prototype.hasOwnProperty.call(data,'redirect')) {
                    window.location.href = data.redirect
                }

                if (Object.prototype.hasOwnProperty.call(data,'popup')) {
                    this.$store.dispatch('popups/addPopup', data.popup).catch(() => {});
                }

                if (Object.prototype.hasOwnProperty.call(data, 'action')) {
                    this.callAction(data.action)
                }
            }
        },

        createInterceptors() {
            let app = this

            this.$api.call.interceptors.request.use(function (config) {
                if (!config.disabled) {
                    app.$request.total++
                }

                config.headers.get['X-Last-Route-Name'] = app.$lastRoute.name
                config.headers.get['X-Last-Route-Path'] = app.$lastRoute.path

                return config
            }, function (error) {
                app.subtractTotalRequests()

                return Promise.reject(error)
            })

            this.$api.call.interceptors.response.use(function (response) {
                app.subtractTotalRequests()
                app.$responseChain(response.data)

                return response
            }, function (error) {
                app.subtractTotalRequests()

                if (error.response.status === 419) {
                    app.$api.getCsrfToken()
                    app.$store.dispatch('popups/addNotification', {
                        message: app.$vuetify.lang.t('$vuetify.text.csrf')
                    }).catch(() => {})
                } else {
                    app.$responseChain(error.response.data)
                }

                return Promise.reject(error)
            })
        },

        subtractTotalRequests() {
            if (this.$request.total > 0) {
                this.$request.total--
            } else if (this.$request.total < 0) {
                this.$request.total = 0
            }
        },

        createPreferenceActions() {
            let app = this
            const update = _.debounce(() => this.$store.dispatch('user/auth/updatePreferences'), 1000);

            this.$store.subscribe((mutation) => {
                if (mutation.type === 'user/auth/setPreference') {
                    const value = mutation.payload.value

                    switch (mutation.payload.type) {
                        case 'dark_mode':
                            app.$vuetify.theme.dark = value
                    }

                    if (app.$store.getters['user/auth/isPreferenceLoaded']) {
                        update()
                    }
                }
            });
        }
    }
});
