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

                    return permissions.includes('super_admin') || permissions.includes(permission)
                }

                return true
            },

            cannot(permission) {
                return !this.can(permission)
            }
        }

        Vue.directive('can', {
            bind: function (el, binding, vNode) {
                if (app.$auth.cannot(binding.value)) {
                    el.style.display = 'none'
                }
            }
        })
    }
}
