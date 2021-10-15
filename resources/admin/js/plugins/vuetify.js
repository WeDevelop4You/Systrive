import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import translations from '../../../../lang/frontend'

import '@fortawesome/fontawesome-free/css/all.css'

Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        dark: false,

        themes: {
            light: {
                primary: '#fc4a1a',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
            },
            dark: {
                primary: '#fc4a1a',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
            }
        },

        options: {
            customProperties: false
        },
    },

    lang: {
        locales: translations,
        fallbackLocale: 'en',
    },

    icons: {
        iconfont: 'fa',
    },
})

