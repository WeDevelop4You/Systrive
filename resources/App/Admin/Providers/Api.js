import ApiProvider from "../../../Support/Providers/Api";

class Api extends ApiProvider {
    #store;

    constructor(app, store) {
        super(app);

        this.#store = store;
    }

    /**
     * @param {string} name
     * @param {string|number} parameters
     *
     * @return {string|null}
     */
    companyRoute(name, ...parameters) {
        const companyId = this.#store.getters['company/id']

        return this.route(name, companyId, ...parameters)
    }
}

export default Api
