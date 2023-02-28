import {debounce as _debounce} from "lodash";

class Auth
{
    #store
    #vuetify
    #loaded = false

    constructor(store, vuetify) {
        this.#store = store
        this.#vuetify = vuetify


        this.#store.dispatch('locale/get')
        this.#createPreferenceSubscriber()
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

    #createPreferenceSubscriber() {
        const vuetify = this.#vuetify
        const update = _debounce(() => this.#store.dispatch('auth/updatePreferences'), 1000);

        this.#store.subscribe((mutation) => {
            if (mutation.type === 'auth/setPreference') {
                const value = mutation.payload.value

                switch (mutation.payload.type) {
                    case 'dark_mode':
                        vuetify.theme.dark = value

                        document.documentElement.setAttribute(
                            'data-theme',
                            value ? 'dark' : 'light'
                        );
                }

                if (this.isLoaded()) {
                    update()
                }
            }
        });
    }
}


export default Auth
