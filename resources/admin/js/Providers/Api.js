import axios from "axios";
import Routes from "../config/api.json";
import Helper from "./Helper";

export default class Api
{
    #prefix;
    #app = Helper.getApp()
    #store = Helper.getStore()

    constructor(prefix) {
        this.#prefix = prefix

        this.call = this.#createAxios()
    }

    /**
     * @param {string} name
     * @param {string|number} parameters
     *
     * @return {string|null}
     */
    route(name, ...parameters) {
        const fullName = `${this.#prefix}.${name}`

        if (Object.prototype.hasOwnProperty.call(Routes, fullName)) {
            let route = Routes[fullName]
            const appends = route.match(/\{(.*?)\}/g);

            if (appends !== null) {
                for (let index = 0; index < appends.length; index++) {
                    let parameter = parameters[index]
                    const append = appends[index]

                    if (append.endsWith('?}')) {
                        parameter = parameter ?? ''
                    } else if (!parameter) {
                        console.error(`Missing parameter for [${append}] in API route [${fullName}]`)
                    }

                    route = route.replace(append, parameter);
                }

                if (route.endsWith('/')) {
                    return route.substring(0, route.length - 1);
                }
            }

            return route
        }

        console.error(`API name [${fullName}] not found`)
    }

    /**
     * @param {string} name
     * @param {string|number} parameters
     *
     * @return {string|null}
     */
    companyRoute(name, ...parameters) {
        const identifiers = this.#store.getters['company/identifiers']

        return this.route(name, identifiers.company, identifiers.system, ...parameters)
    }

    getCsrfToken() {
        return this.call.get('/sanctum/csrf-cookie', {disabled: true})
    }

    #createAxios() {
        let lastRequest

        const app = this.#app
        const api = axios.create()

        api.defaults.withCredentials = true
        api.interceptors.request.use((config) => {
            lastRequest = config

            if (!config.disabled) {
                app.$request.total++
            }

            config.headers.get['X-Last-Route-Name'] = app.$activity.lastRoute.name
            config.headers.get['X-Last-Route-Path'] = app.$activity.lastRoute.path

            return config
        }, (error) => {
            this.#subtractTotalRequests()

            return Promise.reject(error)
        })
        api.interceptors.response.use((response) => {
            this.#subtractTotalRequests()

            app.$responseChain(response.data)

            return response
        }, (error) => {
            this.#subtractTotalRequests()

            if (error.response.status === 419) {
                return this.getCsrfToken().then(() => {
                    return api.request(lastRequest)
                })
            } else {
                app.$responseChain(error.response.data)
            }

            return Promise.reject(error)
        })

        return api
    }

    #subtractTotalRequests() {
        const $request = this.#app.$request

        if ($request.total > 0) {
            $request.total--
        } else if ($request.total < 0) {
            $request.total = 0
        }
    }
}
