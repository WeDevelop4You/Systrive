import Vue from "vue";
import Vuetify from 'vuetify/lib/framework'
import translations from '../config/translations'

Vue.use(Vuetify)

export default new Vuetify({
    theme: {
        dark: true,

        themes: {
            light: {
                primary: '#fc4a1a',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
                chartPoint: '#ffffff'
            },
            dark: {
                primary: '#fc4a1a',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
                chartPoint: '#1e1e1e'
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
        values: {
            prev: 'fas fa-angle-left',
            next: 'fas fa-angle-right',
            dropdown: 'fas fa-angle-down',
            expand: 'fas fa-angle-down',
            sort: 'fas fa-angle-up'
        }
    },
})

