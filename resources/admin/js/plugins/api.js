import axios from 'axios'
import $store from '../store'
import ApiRoutes from "../config/api.json";

const api = axios.create()

api.defaults.withCredentials = true

export default {
    install(Vue) {
        Vue.prototype.$api = {
            call: api,

            /**
             * @param {string} route
             * @param {string|number} values
             *
             * @return {string|null}
             */
            route(route, ...values) {
                const fullRouteName = 'admin.' + route

                if (Object.prototype.hasOwnProperty.call(ApiRoutes, fullRouteName)) {
                    let apiRoute = ApiRoutes[fullRouteName]
                    const parameters = apiRoute.match(/\{(.*?)\}/g);

                    if (parameters !== null) {
                        for (let index = 0; index < parameters.length; index++) {
                            let value = values[index]
                            const parameter = parameters[index]

                            if (parameter.endsWith('?}')) {
                                 value = value ?? ''
                            } else if (!value) {
                                console.error(`Missing parameter for [${parameter}] in API route [${fullRouteName}]`)
                            }

                            apiRoute = apiRoute.replace(parameter, value);
                        }

                        if (apiRoute.endsWith('/')) {
                            return apiRoute.substring(0, apiRoute.length - 1);
                        }
                    }

                    return apiRoute
                }

                console.error(`API route [${fullRouteName}] not found`)
            },

            getCsrfToken() {
                return this.call.get('/sanctum/csrf-cookie')
            },

            getCompanySystemIds() {
                return $store.getters['company/system']
            }
        }

        Vue.mixin({
            computed: {
                $loading() {
                    return !!this.$root.requests
                },
            },
        })
    }
}
