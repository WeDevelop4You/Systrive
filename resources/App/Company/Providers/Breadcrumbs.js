import Breadcrumb from "../../../Support/Helpers/Breadcrumb";
import BreadcrumbsProvider from "../../../Support/Providers/Breadcrumbs";

class Breadcrumbs extends BreadcrumbsProvider {
    #vuetify;

    constructor(app, store, router, vuetify) {
        super(app, store, router, vuetify);

        this.#vuetify = vuetify;
    }

    setDashboard(route, extend = false) {
        const companyName = route.params.companyName;

        return this.add(new Breadcrumb(
            this.#vuetify.lang.t('$vuetify.word.dashboard'),
            extend ? {name: 'dashboard', params: {companyName}} : undefined
        ))
    }

    setCms(route) {
        return this.setDashboard(route, true)
            .add(new Breadcrumb(this.#vuetify.lang.t('$vuetify.word.cms')))
            .add(new Breadcrumb(route.params.cmsName))
            .add(new Breadcrumb(this.#vuetify.lang.t('$vuetify.word.table')))
            .add(new Breadcrumb(route.params.tableName))
    }

    setSystem(route, label) {
        return this.setDashboard(route, true)
            .add(new Breadcrumb(this.#vuetify.lang.t('$vuetify.word.system.system')))
            .add(new Breadcrumb(label))
            .add(new Breadcrumb(route.params.name))
    }

    setAdmin(route) {
        return this.setDashboard(route, true)
            .add(new Breadcrumb(this.#vuetify.lang.t('$vuetify.word.admin')))
    }
}

export default Breadcrumbs
