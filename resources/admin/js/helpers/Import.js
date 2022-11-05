import app from "vue"
import store from "../store"
import api from "../providers/Api"
import routes from "../plugins/routes"
import vuetify from "../plugins/vuetify";
import permission from "../config/Permissions"

export default class Import
{
    static api() {
        return new api('admin')
    }

    static app(Vue = undefined) {
        return (Vue ? Vue : app).prototype
    }

    static store() {
        return store
    }

    static vuetify() {
        return vuetify.framework
    }

    static permissions() {
        return permission
    }

    static router() {
        return routes
    }

    static getMainVuexNamespace(VuexNamespace) {
        return VuexNamespace.substring(0, VuexNamespace.lastIndexOf('/'))
    }
}
