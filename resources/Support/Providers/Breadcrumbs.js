import Breadcrumb from "../Helpers/Breadcrumb";

class Breadcrumbs {
    #vuetify
    items = []

    constructor(app, router, vuetify) {
        this.#vuetify = vuetify;

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
        router.afterEach((to) => {
            const meta = to.meta

            this.items = []

            if (meta.breadcrumbs instanceof Function) {
                meta.breadcrumbs.call(this, {app, vuetify, route: to})
            }
        })
    }

    add(item) {
        this.items.push(item)

        return this
    }

    remove() {
        const index = this.items.findIndex(
            (item) => Object.prototype.hasOwnProperty.call(item.additional, 'added')
        )

        if (index > -1) {
            this.items.splice(index, this.items.length - index)
        }

        return this
    }

    setDashboard(extend = false) {
        return this.add(new Breadcrumb(
            this.#vuetify.lang.t('$vuetify.word.dashboard'),
            extend ? { name: 'dashboard' } : undefined
        ))
    }
}

export default Breadcrumbs
