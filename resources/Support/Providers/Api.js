import psl from "psl";
import axios from "axios";
import routes from "../Config/Api.json";

class Api
{
    call;
    #app;

    constructor(app) {
        this.#app = app
        this.#create()

        app.$actions.add(
            'requestAction',
            ({url, method, params}) => {
                return this.call({
                    url: url,
                    method: method,
                    data: params
                })
            }
        )
    }

    /**
     * @param {string} name
     * @param {string|number} parameters
     *
     * @return {string|null}
     */
    route(name, ...parameters) {
        try {
            let route = this.#getRoute(name)
            const appends = route.match(/\{(.*?)\}/g);

            if (appends !== null) {
                for (let index = 0; index < appends.length; index++) {
                    let parameter = parameters[index]
                    const append = appends[index]

                    if (append.endsWith('?}')) {
                        parameter = parameter ?? ''
                    } else if (!parameter) {
                        console.error(`Missing parameter for [${append}] in API route [${name}]`)
                    }

                    route = route.replace(append, parameter);
                }

                if (route.endsWith('/')) {
                    return route.substring(0, route.length - 1);
                }
            }

            return route
        } catch (e) {
            console.error(e.message)
        }
    }

    #getRoute(name) {
        if (Object.prototype.hasOwnProperty.call(routes, name)) {
            const application = name.split('.').at(0)
            const host = psl.parse(document.location.hostname)

            const route = routes[name]
            const domain = host.domain
            const protocol = document.location.protocol
            const subDomain = this.#getSubDomain(application, host.subdomain)

            return `${protocol}//${subDomain}${domain}${route}`
        }

        throw new Error(`API name [${name}] not found`)
    }

    #getSubDomain(application, current) {
        switch (application) {
            case 'admin': return 'admin.'
            case 'account': return 'account.'
            case 'company': return 'company.'
            default: return current ? `${current}.` : ''
        }
    }

    #create() {
        let lastRequest

        const app = this.#app
        const api = axios.create()

        api.defaults.withCredentials = true
        api.interceptors.request.use((config) => {
            if (!config.silence) {
                app.$request.total++
            }

            if (config.url !== '/sanctum/csrf-cookie') {
                lastRequest = config
            }

            return config
        }, (error) => {
            this.#subtractTotalRequests()

            return Promise.reject(error)
        })
        api.interceptors.response.use((response) => {
            app.$responseChain(response.data)

            this.#subtractTotalRequests()

            return response
        }, (error) => {
            this.#subtractTotalRequests()

            if (error.response.status === 419) {
                return api.get('/sanctum/csrf-cookie', {silence: true}).then(() => {
                    return api.request(lastRequest)
                })
            } else {
                app.$responseChain(error.response.data)
            }

            return Promise.reject(error)
        })

        this.call = api
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

export default Api
