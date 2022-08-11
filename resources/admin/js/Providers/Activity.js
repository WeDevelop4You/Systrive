import Helper from "./Helper";

export default class Activity
{
    lastRoute
    #vuexNamespaces = []

    addVuexNamespace(actionNamespace) {
        const vuexNamespace = Helper.getMainVuexNamespace(actionNamespace)

        if (!this.#vuexNamespaces.includes(vuexNamespace)) {
            this.#vuexNamespaces.push(vuexNamespace)
        }
    }

    hasVuexNamespace(vuexNamespace) {
        return this.#vuexNamespaces.includes(vuexNamespace)
    }

    resetVuexNamespaces() {
        this.#vuexNamespaces = []
    }
}
