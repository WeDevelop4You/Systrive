import {STATE_ALL, STATE_EDIT, STATE_CREATE, STATE_SHOW} from "../Config/RouteState";

export default class Loader
{
    #app
    #store
    #router
    #loadStates = []

    constructor(app, store, router) {
        this.#app = app;
        this.#store = store;
        this.#router = router;

        // this.#createSubscribeAction()
    }

    #createSubscribeAction() {
        const app = this.#app;

        this.#store.subscribeAction({
            before: (action) => {
                app.$activity.addVuexNamespace(action.type)
            },
        })
    }

    convertStringToRouteParams() {
        const currentRoute = this.#router.currentRoute
        const chaptersString = currentRoute.params.chapters
        const allowedStates = currentRoute.meta.allowedStates || []

        if (chaptersString !== undefined && !Array.isArray(chaptersString)) {
            const parameters = chaptersString.split('/')
            const length = parameters.length

            if (length > 0) {
                for (let i = 0; i < length;) {
                    const state = parameters[i]
                    const action = {state, params: {}}
                    const nextParameter = () => {
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

                        return nextParameter();
                    }

                    if (allowedStates.includes(state)) {
                        const parameters = {state, ...nextParameter()}

                        switch (state) {
                            case STATE_CREATE:
                            case STATE_EDIT:
                                this.#app.$state.setParams('form', parameters); break
                            case STATE_SHOW:
                                this.#app.$state.setParams('show', parameters); break
                        }

                        this.#loadStates.push(action)
                    } else {
                        i++
                    }
                }
            }
        }
    }

    runStateAction(vuexNamespace) {
        if (this.#loadStates.length > 0) {
            const action = this.#loadStates.shift()

            if (action.params.type !== undefined) {
                vuexNamespace = this.#getVuexNamespaceByType(action.params.type) ?? vuexNamespace
            }

            this.#store.dispatch(`${vuexNamespace}/states`, action).catch(() => {})
        }
    }

    #getVuexNamespaceByType(type) {
        switch (type) {
            case 'user': return 'company/users'
            case 'role': return 'company/roles'
            case 'cms': return 'company/cms'
            case 'table': return 'cms/table'
            default: return undefined
        }
    }
}
