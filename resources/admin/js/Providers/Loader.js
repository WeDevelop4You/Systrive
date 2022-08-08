import _ from "lodash";
import Helper from "./Helper";
import {STATE_ALL, STATE_EDIT, STATE_NEW, STATE_SHOW} from "./Config";

export default class Loader
{
    #loadStates = []
    #app = Helper.getApp()
    #store = Helper.getStore()
    #router = Helper.getRouter()
    #vuetify = Helper.getVuetify()

    constructor() {
        this.#createSubscribe()
        this.#createSubscribeAction()

        this.#load()
    }

    #load() {
        this.#store.dispatch('locale/getOne')
        this.#store.dispatch('locale/getMany')
    }

    #createSubscribe() {
        const app = this.#app;
        const vuetify = this.#vuetify
        const update = _.debounce(() => this.#store.dispatch('user/auth/updatePreferences'), 1000);

        this.#store.subscribe((mutation) => {
            if (mutation.type === 'user/auth/setPreference') {
                const value = mutation.payload.value

                switch (mutation.payload.type) {
                    case 'dark_mode':
                        vuetify.theme.dark = value
                }

                if (app.$auth.check()) {
                    update()
                }
            }
        });
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
                    const action = {state, params: []}
                    const nextParameter = function () {
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
                            case STATE_NEW:
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
            default: return undefined
        }
    }
}
