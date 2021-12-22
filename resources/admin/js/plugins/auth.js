import Vue from 'vue';
import store from '../store'

const app = Vue.prototype

export default {
    install(Vue) {
        Vue.prototype.$auth = {
            user() {
                return store.getters['user/get']
            },

            can(permission) {
                if (permission !== undefined) {
                    const permissions = store.getters['user/getPermissions']

                    return permissions.includes(app.$config.permissions.superAdmin) || permissions.includes(permission)
                }

                return true
            },

            cannot(permission) {
                return !this.can(permission)
            }
        }
    }
}
