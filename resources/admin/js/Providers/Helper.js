import app from "vue"
import api from "./Api"
import store from "../store"
import routes from "../plugins/routes"
import vuetify from "../plugins/vuetify";
import permission from "../config/permissions"

export default class Helper
{
    static getApi() {
        return new api('admin')
    }

    static getApp(Vue = undefined) {
        return (Vue ? Vue : app).prototype
    }

    static getStore() {
        return store
    }

    static getVuetify() {
        return vuetify.framework
    }

    static getPermissions() {
        return permission
    }

    static getRouter() {
        return routes
    }

    static getMainVuexNamespace(VuexNamespace) {
        return VuexNamespace.substring(0, VuexNamespace.lastIndexOf('/'))
    }
}
