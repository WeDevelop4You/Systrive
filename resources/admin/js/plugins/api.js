import axios from 'axios'
import ApiRoutes from "../config/api.json";

let api = axios.create()

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
                if (ApiRoutes.hasOwnProperty(route)) {
                    let apiRoute = ApiRoutes[route]
                    let parameters = apiRoute.match(/\{(.*?)\}/g);

                    if (parameters !== null) {
                        for (let index = 0; index < parameters.length; index++) {
                            let value = values[index]
                            let parameter = parameters[index]

                            parameter.endsWith('?}')
                                ? value = value ?? ''
                                : console.error(`Missing parameter for [${parameter}] in API route [${route}]`)

                            apiRoute = apiRoute.replace(parameter, value);
                        }

                        if (apiRoute.endsWith('/')) {
                            return apiRoute.substring(0, apiRoute.length - 1);
                        }
                    }

                    return apiRoute
                }

                console.error(`API route [${route}] not found`)
            },

            getCsrfToken() {
                return this.call.get('/sanctum/csrf-cookie')
            },
        }
    }
}
