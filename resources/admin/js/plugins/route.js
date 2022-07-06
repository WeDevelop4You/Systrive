import Store from '../store'
import Router from './routes'
import {STATE_EDIT, STATE_NEW, STATE_SHOW, STATE_ALL} from "./config";

const $store = Store
const $router = Router

export default {
    install(Vue) {
        Vue.prototype.$routeLoader = {
            setForm(isEdit, parameters) {
                let params = {
                    state: isEdit ? STATE_EDIT : STATE_NEW,
                    ...parameters
                }

                this.setParams('form', params).setRoute()
            },

            setShow(parameters) {
                const params = {
                    state: STATE_SHOW,
                    ...parameters
                }

                this.setParams('show', params).setRoute()
            },

            resetForm() {
                delete this._params.form

                this.setRoute()
            },

            resetShow() {
                delete this._params.show

                this.setRoute()
            },

            setParams(type, params) {
                Object.assign(this._params, {[type]: params})

                return this
            },

            setRoute() {
                let chapters = []
                let currentRoute = $router.currentRoute

                for (let parameter of Object.entries(this._params)) {
                    chapters = chapters.concat(Object.values(parameter[1]))
                }

                currentRoute.params.chapters = chapters

                $router.replace(currentRoute).catch(() => {})
            },

            convertStringToRouteParams() {
                const currentRoute = $router.currentRoute
                const chaptersString = currentRoute.params.chapters
                const allowedStates = currentRoute.meta.allowedStates || []

                if (chaptersString !== undefined && !Array.isArray(chaptersString)) {
                    const parameters = chaptersString.split('/')
                    const length = parameters.length

                    if (length > 0) {
                        for (let i = 0; i < length;) {
                            const state = parameters[i]
                            const action = {state, params: []}
                            const nextParam = function () {
                                const parameter = parameters[++i];

                                if (STATE_ALL.includes(parameter) || i >= length) {
                                    return action.params
                                } else {
                                    if (!isNaN(parameter) && parameter % 1 === 0 && parameter > 0) {
                                        action.params.id = parameter
                                    } else {
                                        action.params.type = parameter
                                    }
                                }

                                return nextParam();
                            }

                            if (allowedStates.includes(state)) {
                                const params = {state, ...nextParam()}

                                switch (state) {
                                    case STATE_NEW:
                                    case STATE_EDIT:
                                        this.setParams('form', params); break
                                    case STATE_SHOW:
                                        this.setParams('show', params); break
                                }

                                this._loadStates.push(action)
                            } else {
                                i++
                            }
                        }
                    }
                }
            },

            runStateAction(vuexNamespace) {
                if (this._loadStates.length > 0) {
                    const action = this._loadStates.shift()

                    if (action.params.type !== undefined) {
                        vuexNamespace = this.getVuexNamespaceByType(action.params.type) ?? vuexNamespace
                    }

                    $store.dispatch(`${vuexNamespace}/states`, action).catch(() => {})
                }
            },

            getVuexNamespaceByType(type) {
                switch (type) {
                    case 'user': return 'company/users'
                    case 'role': return 'company/roles'
                    default: return undefined
                }
            },

            _params: {},
            _loadStates: [],

        }
    },
}
