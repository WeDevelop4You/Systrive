import Import from "../helpers/Import";

export default class Activity
{
    lastRoute
    #vuexNamespaces = []

    addVuexNamespace(actionNamespace) {
        const vuexNamespace = Import.getMainVuexNamespace(actionNamespace)

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
