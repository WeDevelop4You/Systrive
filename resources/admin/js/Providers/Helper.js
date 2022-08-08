export default class Helper
{
    static getApi() {
        return new (require('./Api').default)('admin')
    }

    static getApp(Vue = undefined) {

        return (Vue ? Vue : require('vue').default).prototype
    }

    static getStore() {
        return require('../store').default
    }

    static getVuetify() {
        return require('../plugins/vuetify').default.framework
    }

    static getPermissions() {
        return require('../config/permissions').default
    }

    static getRouter() {
        return require('../plugins/routes').default;
    }

    static getMainVuexNamespace(VuexNamespace) {
        return VuexNamespace.substring(0, VuexNamespace.lastIndexOf('/'))
    }
}
