import Store from '../store'
import Permissions from "../config/permissions";

const $store = Store
const $permissions = Permissions

export default {
    install(Vue) {
        Vue.prototype.$auth = {
            user() {
                return $store.getters['user/auth/data']
            },

            getPreference(type) {
                const preferences = $store.getters['user/auth/preferences']

                if (Object.prototype.hasOwnProperty.call(preferences, type)) {
                    return preferences[type]
                }

                return undefined
            },

            updatePreference(type, value) {
                $store.commit('user/auth/setPreference', {type, value})
            },

            can(permissions, requiresAll = false) {
                const userPermissions = $store.getters['user/auth/permissions/getItems']

                if (permissions !== undefined && !userPermissions.includes($permissions.superAdmin)) {
                    permissions = Array.isArray(permissions)
                        ? permissions
                        : new Array(permissions)

                    const hasPermissions = permissions.map((permission) => {
                        return userPermissions.includes(permission)
                    }).filter(Boolean).length

                    return requiresAll
                        ? hasPermissions === permissions.length
                        : hasPermissions > 0
                }

                return true
            },

            cannot(permissions, requiresAll = false) {
                return !this.can(permissions, requiresAll)
            }
        }
    }
}
