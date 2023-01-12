class Auth
{
    #store
    #loaded = false

    constructor(store) {
        this.#store = store

        this.#store.dispatch('getLocale')

    }

    async load() {
        if (!this.#loaded) {
            const hasUser = await this.#store.dispatch('auth/getUser')
            const hasPreferences = await this.#store.dispatch('auth/getPreferences')

            this.#loaded = (hasUser && hasPreferences)
        }
    }

    user() {
        return this.#store.getters['auth/data']
    }

    check() {
        return false
    }

    isLoaded() {
        return this.#loaded
    }

    preference(key) {
        const preferences = this.#store.getters['auth/preferences']

        if (Object.prototype.hasOwnProperty.call(preferences, key)) {
            return preferences[key]
        }

        return undefined
    }

    changePreference(type, value) {
        this.#store.commit('auth/setPreference', {type, value})
    }
}


export default Auth
