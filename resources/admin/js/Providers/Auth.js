import Helper from "./Helper";

export default class Auth
{
    #isLoaded = false;
    #store = Helper.getStore();
    #permissions = Helper.getPermissions();

    async load() {
        if (!this.#isLoaded) {
            const hasUser = await this.#store.dispatch('user/auth/getOne')
            const hasPreferences = await this.#store.dispatch('user/auth/getPreferences')

            this.#isLoaded = (hasUser && hasPreferences)
        }
    }

    check() {
        return this.#isLoaded
    }

    user() {
        return this.#store.getters['user/auth/data']
    }

    preference(key) {
        const preferences = this.#store.getters['user/auth/preferences']

        if (Object.prototype.hasOwnProperty.call(preferences, key)) {
            return preferences[key]
        }

        return undefined
    }

    changePreference(type, value) {
        this.#store.commit('user/auth/setPreference', {type, value})
    }

    can(permissions, requiresAll = false) {
        const userPermissions = this.#store.getters['user/auth/permissions/getItems']

        if (permissions !== undefined && !userPermissions.includes(this.#permissions.superAdmin)) {
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
    }

    cannot(permissions, requiresAll = false) {
        return !this.can(permissions, requiresAll)
    }
}
