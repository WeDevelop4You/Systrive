import Breadcrumb from "../helpers/Breadcrumb";
import Import from "../helpers/Import";

const $store = Import.store()
const $vuetify = Import.vuetify()

class Breadcrumbs {
    items = []

    set(items) {
        this.items = items

        return this
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
        return this.set([
            new Breadcrumb(
                $vuetify.lang.t('$vuetify.word.dashboard'),
                extend ? { name: 'dashboard' } : undefined
            ),
        ])
    }

    setCompany(route, extend = false) {
        const companyName = route.params.companyName;

        return this.setDashboard(true)
            .add(new Breadcrumb(
                companyName,
                extend ? {name: 'company.dashboard', params: {companyName: companyName}} : undefined
            ))
    }

    setCompanyCms(route) {
        return this.setCompany(route, true)
            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.cms')))
            .add(new Breadcrumb(route.params.cmsName))
            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.table')))
            .add(new Breadcrumb(route.params.tableName))
    }

    setCompanySystem(route, label) {
        return this.setCompany(route, true)
            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.system.system')))
            .add(new Breadcrumb(label))
            .add(new Breadcrumb(route.params.name))
    }

    setCompanyAdmin(route) {
        return this.setCompany(route, true)
            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.admin')))
    }

    setSuperAdmin() {
        return this.setDashboard(true)
            .add(new Breadcrumb($vuetify.lang.t('$vuetify.word.sa.sa')))
    }
}

export default Breadcrumbs
