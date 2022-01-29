import store from '../store'
import Permissions from "../config/permissions";

const $permissions = Permissions

export default {
    install(Vue) {
        Vue.prototype.$auth = {
            user() {
                return store.getters['user/get']
            },

            can(permissions, requiresAll = false) {
                const userPermissions = store.getters['user/getPermissions']

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
