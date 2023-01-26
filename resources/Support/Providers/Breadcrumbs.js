import Breadcrumb from "../Helpers/Breadcrumb";
import BreadcrumbsModule from "../Store/Modules/breadcrumbs";

class Breadcrumbs {
    #store;
    #vuetify;

    constructor(app, store, router, vuetify) {
        this.#store = store;
        this.#vuetify = vuetify;

        this.#registerModule()
        this.#createActions(app)

        router.afterEach((to) => {
            this.#store.commit('breadcrumbs/reset')

            if (to.meta.breadcrumbs instanceof Function) {
                to.meta.breadcrumbs.call(this, {app, vuetify, route: to})
            }
        })
    }

    add(item) {
        this.#store.commit('breadcrumbs/add', item)

        return this
    }

    remove() {
        this.#store.commit('breadcrumbs/remove', item)

        return this
    }

    setDashboard(extend = false) {
        return this.add(new Breadcrumb(
            this.#vuetify.lang.t('$vuetify.word.dashboard'),
            extend ? { name: 'dashboard' } : undefined
        ))
    }

    #registerModule() {
        this.#store.registerModule('breadcrumbs', BreadcrumbsModule)
    }

    #createActions(app) {
        app.$actions.add(
            'breadcrumbsAddAction',
            (items) => {
                this.remove()

                items.forEach((item) => {
                    this.add(new Breadcrumb(item.label, item.to, item.additional))
                })
            }
        )
        app.$actions.add(
            'breadcrumbsRemoveAction',
            () => {
                this.remove()
            }
        )
    }
}

export default Breadcrumbs
